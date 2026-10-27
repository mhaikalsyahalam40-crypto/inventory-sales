<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori | Nexora Tech</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        header { background: #1e3a8a; color: white; padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; gap: 15px; }
        header a { color: white; text-decoration: none; }
        main { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .top { display: flex; justify-content: space-between; align-items: center; gap: 15px; margin-bottom: 20px; }
        h1 { font-size: 25px; margin: 0 0 8px; }
        p { color: #64748b; }
        .btn { display: inline-block; padding: 11px 15px; border: 0; border-radius: 8px; background: #2563eb; color: white; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn:hover { background: #1e3a8a; }
        .btn-edit { background: #dbeafe; color: #1e3a8a; }
        .btn-delete { background: #fee2e2; color: #b91c1c; }
        .panel { background: white; border-radius: 12px; padding: 22px; box-shadow: 0 4px 16px #1e3a8a0a; overflow-x: auto; }
        .alert { padding: 13px; border-radius: 8px; margin-bottom: 15px; background: #dcfce7; color: #166534; }
        .alert.error { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; min-width: 600px; }
        th, td { padding: 14px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        th { color: #64748b; background: #f8fafc; font-size: 12px; }
        .actions { display: flex; align-items: center; gap: 7px; }
        .actions form { margin: 0; }
        .empty { padding: 30px; text-align: center; color: #64748b; }
        .pagination { margin-top: 20px; }
        .back { font-size: 13px; }
        @media(max-width: 600px) { header { padding: 16px 20px; } .top { align-items: flex-start; flex-direction: column; } main { margin-top: 22px; } }
    </style>
</head>
<body>
<header>
    <a href="{{ route('dashboard') }}"><strong>▦ Inventory &amp; Sales</strong></a>
    <a href="{{ route('dashboard') }}">← Dashboard</a>
</header>

<main>
    <div class="top">
        <div>
            <h1>Manajemen Kategori</h1>
            <p>Kelola kategori untuk mengelompokkan produk inventori.</p>
        </div>
        <a class="btn" href="{{ route('categories.create') }}">+ Tambah Kategori</a>
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
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->description ?: '-' }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-edit" href="{{ route('categories.edit', $category) }}">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-delete" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty">Belum ada kategori. Klik Tambah Kategori untuk membuat kategori pertama.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">{{ $categories->links() }}</div>
    </section>
</main>
</body>
</html>
