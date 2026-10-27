<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembelian | Nexora Tech</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0000000d;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        h1 { color: #1e3a8a; margin: 0; }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn:hover { background: #1e40af; }
        .btn-secondary { background: #64748b; }
        .btn-secondary:hover { background: #475569; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #991b1b; }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            padding: 18px;
            margin: 20px 0;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .field label {
            font-size: 13px;
            font-weight: bold;
        }

        .field input,
        .field select {
            width: 100%;
            min-height: 40px;
            padding: 9px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            color: #1e293b;
        }

        .filter-actions {
            grid-column: 1 / -1;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            min-width: 850px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th { background: #1e3a8a; color: white; }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            background: #dcfce7;
            color: #166534;
            white-space: nowrap;
        }

        .status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            padding: 30px;
        }

        .pagination { margin-top: 20px; }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
            flex-wrap: wrap;
        }

        .actions form { margin: 0; }

        @media (max-width: 900px) {
            .filters { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 650px) {
            body { padding: 12px; }
            .container { padding: 16px; }
            .filters { grid-template-columns: 1fr; }
            .filter-actions { grid-column: auto; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <h1>Data Pembelian Barang</h1>

        <a href="{{ route('purchases.create') }}" class="btn">
            + Tambah Pembelian
        </a>
    </div>

    <p>
        <a href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
    </p>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Periksa kembali input:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.index') }}" method="GET" class="filters">

        <div class="field">
            <label for="search">Cari pembelian</label>
            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                maxlength="100"
                placeholder="Nomor pembelian atau supplier"
            >
        </div>

        <div class="field">
            <label for="start_date">Tanggal mulai</label>
            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ request('start_date') }}"
            >
        </div>

        <div class="field">
            <label for="end_date">Tanggal akhir</label>
            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ request('end_date') }}"
            >
        </div>

        <div class="field">
            <label for="status">Status transaksi</label>
            <select id="status" name="status">
                <option value="">Semua status</option>
                <option value="completed"
                    {{ request('status') === 'completed' ? 'selected' : '' }}>
                    Selesai
                </option>
                <option value="cancelled"
                    {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                    Dibatalkan
                </option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn">Cari / Filter</button>

            <a href="{{ route('purchases.index') }}"
               class="btn btn-secondary">
                Reset Filter
            </a>
        </div>
    </form>

    <p>
        Menampilkan {{ $purchases->firstItem() ?? 0 }}–{{ $purchases->lastItem() ?? 0 }}
        dari {{ $purchases->total() }} transaksi.
    </p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Pembelian</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Petugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchases->firstItem() + $loop->index }}</td>

                        <td>{{ $purchase->purchase_number }}</td>

                        <td>{{ $purchase->supplier->name ?? '-' }}</td>

                        <td>
                            {{ $purchase->purchased_at?->format('d-m-Y H:i') ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format((float) $purchase->total, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="status {{ $purchase->status === 'cancelled' ? 'cancelled' : '' }}">
                                {{ $purchase->status === 'completed'
                                    ? 'Selesai'
                                    : ($purchase->status === 'cancelled'
                                        ? 'Dibatalkan'
                                        : ucfirst($purchase->status)) }}
                            </span>
                        </td>

                        <td>{{ $purchase->user->name ?? '-' }}</td>

                        <td>
                            <div class="actions">
                                <a
                                    href="{{ route('purchases.show', $purchase) }}"
                                    class="btn"
                                >
                                    Detail
                                </a>

                                @if (
                                    auth()->check()
                                    && auth()->user()->role === 'admin'
                                    && $purchase->status === 'completed'
                                )
                                    <form
                                        action="{{ route('purchases.destroy', $purchase) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin membatalkan pembelian ini? Stok akan dikurangi sesuai rincian transaksi.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">
                            Tidak ada transaksi yang cocok dengan pencarian atau filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $purchases->links() }}
    </div>

</div>
</body>
</html>
