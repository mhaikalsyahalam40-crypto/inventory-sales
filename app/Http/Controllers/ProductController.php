<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk, pencarian, dan filter kategori.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories'
        ));
    }

    /**
     * Menampilkan formulir tambah produk.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru dengan SKU otomatis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        // Buat SKU dan simpan produk dalam transaksi database.
        $sku = DB::transaction(function () use ($validated) {
            // Mengunci tabel untuk mencegah dua proses membuat SKU
            // yang sama pada saat bersamaan.
            $lastNumber = Product::query()
                ->where('sku', 'like', 'PRD-%')
                ->lockForUpdate()
                ->pluck('sku')
                ->map(function ($existingSku) {
                    return preg_match(
                        '/^PRD-(\d+)$/',
                        $existingSku,
                        $matches
                    ) ? (int) $matches[1] : 0;
                })
                ->max() ?? 0;

            // Cari SKU berikutnya yang belum digunakan.
            do {
                $lastNumber++;

                $newSku = 'PRD-' . str_pad(
                    $lastNumber,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            } while (Product::where('sku', $newSku)->exists());

            $validated['sku'] = $newSku;

            Product::create($validated);

            return $newSku;
        });

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                "Produk berhasil ditambahkan dengan kode {$sku}."
            );
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan formulir edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Memperbarui produk tanpa mengubah SKU.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        // SKU sengaja tidak diubah ketika produk diedit.
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk yang belum digunakan dalam transaksi.
     */
    public function destroy(Product $product)
    {
        if (
            $product->purchaseItems()->exists()
            || $product->saleItems()->exists()
        ) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi.'
                );
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
