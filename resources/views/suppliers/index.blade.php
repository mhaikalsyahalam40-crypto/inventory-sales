<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemasok | Inventory & Sales</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "Segoe UI", Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        header { background: #1e3a8a; color: white; padding: 20px 5%; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; }
        main { max-width: 1200px; margin: 32px auto; padding: 0 20px; }
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
        .filters input { flex: 1; min-width: 220px; padding: 11px; border: 1px solid #cbd5e1; border-radius: 8px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 14px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        th { color: #64748b; background: #f8fafc; font-size: 11px; text-transform: uppercase; }
        .actions { display: flex; gap: 7px; align-items: center; }
        .actions form { margin: 0; }
        .empty { padding: 35px; text-align: center; color: #64748b; }
        .summary { color: #64748b; font-size: 12px; margin-bottom: 15px; }
        .pagination { margin-top: 20px; }
        @media(max-width: 600px) { .top { align-items: flex-start; flex-direction: column; } main { margin-top: 22px; } }
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
            <h1>Manajemen Pemasok</h1>
            <p>Kelola informasi pemasok dan mitra pengadaan barang.</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="btn">＋ Tambah Pemasok</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <section class="panel">
        <form method="GET" action="{{ route('suppliers.index') }}" class="filters">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau nomor telepon...">
            <button class="btn" type="submit">Cari</button>
            <a href="{{ route('suppliers.index') }}" class="btn edit">Reset</a>
        </form>

        <div class="summary">
            Menampilkan {{ $suppliers->firstItem() ?? 0 }}–{{ $suppliers->lastItem() ?? 0 }}
            dari {{ $suppliers->total() }} pemasok
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pemasok</th>
                        <th>Nomor Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->phone ?: '-' }}</td>
                            <td>{{ $supplier->email ?: '-' }}</td>
                            <td>{{ $supplier->address ?: '-' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn edit">Edit</a>
                                    <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Yakin ingin menghapus pemasok ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">Belum ada data pemasok. Tambahkan pemasok pertama kamu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $suppliers->links() }}</div>
    </section>
</main>
</body>
</html>
