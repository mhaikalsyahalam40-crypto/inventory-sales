<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class PurchaseController extends Controller
{
    /**
     * Menampilkan daftar pembelian beserta pencarian dan filter.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:start_date',
            ],
            'status' => [
                'nullable',
                Rule::in(['completed', 'cancelled']),
            ],
        ]);

        $query = Purchase::with(['supplier', 'user']);

        // Pencarian nomor pembelian atau nama supplier.
        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function (Builder $q) use ($search) {
                $q->where('purchase_number', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function (Builder $supplierQuery) use ($search) {
                        $supplierQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter tanggal mulai.
        if (!empty($filters['start_date'])) {
            $query->whereDate(
                'purchased_at',
                '>=',
                $filters['start_date']
            );
        }

        // Filter tanggal akhir.
        if (!empty($filters['end_date'])) {
            $query->whereDate(
                'purchased_at',
                '<=',
                $filters['end_date']
            );
        }

        // Filter status transaksi.
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $purchases = $query
            ->orderByDesc('purchased_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Menampilkan formulir pembelian.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact(
            'suppliers',
            'products'
        ));
    }

    /**
     * Menyimpan transaksi pembelian dan menambah stok.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => [
                'required',
                'integer',
                'exists:suppliers,id',
            ],
            'purchased_at' => [
                'required',
                'date',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'items.*.unit_cost' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $purchase = DB::transaction(function () use ($validated) {
            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'purchase_number' => $this->generatePurchaseNumber(),
                'total' => 0,
                'status' => 'completed',
                'purchased_at' => $validated['purchased_at'],
            ]);

            $total = 0;

            // Urutkan produk agar urutan penguncian konsisten.
            $items = collect($validated['items'])
                ->sortBy('product_id');

            foreach ($items as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];
                $unitCost = (float) $item['unit_cost'];
                $subtotal = $quantity * $unitCost;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'subtotal' => $subtotal,
                ]);

                $product->increment('stock', $quantity);

                $total += $subtotal;
            }

            $purchase->update([
                'total' => $total,
            ]);

            return $purchase;
        });

        return redirect()
            ->route('purchases.index')
            ->with(
                'success',
                'Transaksi pembelian berhasil disimpan dan stok telah ditambahkan.'
            );
    }

    /**
     * Menampilkan detail pembelian.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load([
            'supplier',
            'user',
            'items.product',
        ]);

        return view('purchases.show', compact('purchase'));
    }

    /**
     * Membatalkan pembelian dan mengurangi stok.
     * Route ini harus dibatasi untuk Admin.
     */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            $purchase = Purchase::whereKey($purchase->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($purchase->status !== 'completed') {
                abort(
                    422,
                    'Pembelian ini sudah dibatalkan atau tidak dapat dibatalkan.'
                );
            }

            $items = $purchase->items()
                ->orderBy('product_id')
                ->get();

            // Kunci semua produk terlebih dahulu.
            $productIds = $items
                ->pluck('product_id')
                ->unique()
                ->sort()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Pastikan semua produk masih ada dan stok mencukupi.
            foreach ($items as $item) {
                $product = $products->get($item->product_id);

                if (!$product) {
                    abort(
                        422,
                        'Pembatalan gagal karena produk tidak ditemukan.'
                    );
                }

                if ($product->stock < $item->quantity) {
                    abort(
                        422,
                        'Pembatalan gagal karena stok produk tidak mencukupi.'
                    );
                }
            }

            // Kurangi stok setelah seluruh item lolos pemeriksaan.
            foreach ($items as $item) {
                $products
                    ->get($item->product_id)
                    ->decrement('stock', $item->quantity);
            }

            $purchase->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('purchases.index')
            ->with(
                'success',
                'Pembelian berhasil dibatalkan dan stok telah disesuaikan.'
            );
    }

    /**
     * Membuat nomor pembelian unik.
     */
    private function generatePurchaseNumber(): string
    {
        do {
            $number = 'PO-' . now()->format('YmdHis')
                . '-' . strtoupper(bin2hex(random_bytes(3)));
        } while (
            Purchase::where('purchase_number', $number)->exists()
        );

        return $number;
    }
}
