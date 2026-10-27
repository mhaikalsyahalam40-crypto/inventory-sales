<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    /**
     * Menampilkan daftar penjualan.
     */
   
public function index(Request $request)
{
    $validated = $request->validate([
        'search' => ['nullable', 'string', 'max:100'],
        'start_date' => ['nullable', 'date'],
        'end_date' => [
            'nullable',
            'date',
            'after_or_equal:start_date',
        ],
        'status' => [
            'nullable',
            'in:completed,cancelled',
        ],
    ]);

    $query = Sale::with('user');

    // Cari nomor transaksi atau nama kasir.
    if (!empty($validated['search'])) {
        $search = $validated['search'];

        $query->where(function ($q) use ($search) {
            $q->where('sale_number', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
        });
    }

    // Filter tanggal transaksi.
    if (!empty($validated['start_date'])) {
        $query->whereDate('sold_at', '>=', $validated['start_date']);
    }

    if (!empty($validated['end_date'])) {
        $query->whereDate('sold_at', '<=', $validated['end_date']);
    }

    // Filter status.
    if (!empty($validated['status'])) {
        $query->where('status', $validated['status']);
    }

    $sales = $query
        ->orderByDesc('sold_at')
        ->orderByDesc('id')
        ->paginate(10)
        ->withQueryString();

    return view('sales.index', compact('sales'));
}


    /**
     * Menampilkan formulir penjualan.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('sales.create', compact('products'));
    }

    /**
     * Menyimpan penjualan dan mengurangi stok.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sold_at' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'distinct',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $sale = Sale::create([
                'user_id' => $request->user()->id,
                'sale_number' => 'SO-'
                    . now()->format('YmdHis')
                    . '-'
                    . strtoupper(Str::random(4)),
                'total' => 0,
                'status' => 'completed',
                'sold_at' => $validated['sold_at'],
            ]);

            $total = 0;

            // Urutkan produk agar penguncian stok konsisten.
            $items = collect($validated['items'])
                ->sortBy('product_id');

            foreach ($items as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => "Stok produk {$product->name} tidak mencukupi. "
                            . "Stok tersedia: {$product->stock}.",
                    ]);
                }

                // Harga diambil dari database, bukan dari input pengguna.
                $unitPrice = round(
                    (float) $product->selling_price,
                    2
                );

                $subtotal = round($quantity * $unitPrice, 2);

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);

                $total += $subtotal;
            }

            $sale->update([
                'total' => round($total, 2),
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Transaksi penjualan berhasil disimpan dan stok telah dikurangi.'
            );
    }

    /**
     * Menampilkan detail penjualan.
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product']);

        return view('sales.show', compact('sale'));
    }

    /**
     * Membatalkan penjualan dan mengembalikan stok.
     * Akses method ini dibatasi melalui middleware route.
     */
    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Kunci transaksi agar tidak dibatalkan bersamaan.
            $sale = Sale::with('items')
                ->whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($sale->status !== 'completed') {
                throw ValidationException::withMessages([
                    'sale' => 'Penjualan ini sudah dibatalkan atau tidak berstatus selesai.',
                ]);
            }

            $productIds = $sale->items
                ->pluck('product_id')
                ->unique()
                ->sort()
                ->values();

            // Kunci semua produk sebelum stok diubah.
            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Pastikan semua produk masih tersedia.
            foreach ($sale->items as $item) {
                if (!$products->has($item->product_id)) {
                    throw ValidationException::withMessages([
                        'sale' => 'Produk pada transaksi ini tidak ditemukan. Pembatalan tidak dapat dilanjutkan.',
                    ]);
                }
            }

            // Kembalikan stok untuk seluruh item.
            foreach ($sale->items as $item) {
                $products->get($item->product_id)
                    ->increment('stock', $item->quantity);
            }

            // Ubah status setelah penyesuaian stok.
            $sale->update([
                'status' => 'cancelled',
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                'Penjualan berhasil dibatalkan dan stok telah dikembalikan.'
            );
    }
}
