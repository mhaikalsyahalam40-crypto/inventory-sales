<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk | Nexora Tech</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "Segoe UI", Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        header { background: #1e3a8a; color: white; padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; }
        main { max-width: 1250px; margin: 32px auto; padding: 0 20px; }
        .top { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 24px; }
        h1 { margin: 0 0 8px; font-size: 27px; }
        p { color: #64748b; }
        .btn { display: inline-block; padding: 11px 15px; border: 0; border-radius: 8px; background: #2563eb; color: white; text-decoration: none; cursor: pointer; font-size: 13px; }
        .btn:hover { background: #1e3a8a; }
        .edit { background: #dbeafe; color: #1e3a8a; }
        .delete { background: #fee2e2; color: #b91c1c; }
        .panel { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; box-shadow: 0 5px 18px #1e3a8a08; }
        .alert { padding: 13px 16px; border-radius: 9px; margin-bottom: 16px; background: #dcfce7; color: #166534; }
        .alert.error { background: #fee2e2; color: #991b1b; }
        .filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
        .filters input, .filters select { min-width: 180px; flex: 1; padding: 11px; border: 1px solid #cbd5e1; border-radius: 8px; background: white; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th, td { padding: 14px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        th { color: #64748b; background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: .4px; }
        .sku { color: #2563eb; font-weight: 700; }
        .stock { display: inline-block; padding: 5px 9px; border-radius: 20px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 700; }
        .stock.low { background: #fee2e2; color: #b91c1c; }
        .actions { display: flex; gap: 7px; align-items: center; }
        .actions form { margin: 0; }
        .empty { padding: 35px; text-align: center; color: #64748b; }
        .pagination { margin-top: 20px; }
        .summary { color: #64748b; font-size: 12px; margin-bottom: 15px; }
        @media(max-width: 650px) { .top { align-items: flex-start; flex-direction: column; } main { margin-top: 22px; } header { padding: 17px 20px; } }
    </style>
</head>
<body>
<header>
    <a href="{{ route('dashboard') }}"><strong>▦ Nexora Tech</strong></a>
    <a href="{{ route('dashboard') }}">← Dashboard</a>
</header>

<main>
    <div class="top">
        <div>
            <h1>Manajemen Produk</h1>
            <p>Kelola katalog, harga, dan persediaan produk.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn">＋ Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert error">{{ $errors->first() }}</div>
    @endif

    <section class="panel">
        <form class="filters" method="GET" action="{{ route('products.index') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk atau SKU...">

            <select name="category_id">
                <option value="">Semua kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn">Cari / Filter</button>
            <a href="{{ route('products.index') }}" class="btn edit">Reset</a>
        </form>

        <div class="summary">
            Menampilkan {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}
            dari {{ $products->total() }} produk
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $products->firstItem() + $loop->index }}</td>
                            <td class="sku">{{ $product->sku }}</td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>Rp {{ number_format((float) $product->purchase_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}</td>
                            <td>
                                <span class="stock {{ $product->stock <= $product->minimum_stock ? 'low' : '' }}">
                                    {{ $product->stock }}
                                    @if($product->stock <= $product->minimum_stock)
                                        · Menipis
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn edit" href="{{ route('products.edit', $product) }}">Edit</a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn delete" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">Belum ada produk. Tambahkan produk pertama kamu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $products->links() }}</div>
    </section>
</main>
</body>
</html>
