<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan | Nexora Tech</title>

    <style>
        :root {
            --navy: #1e3a8a;
            --blue: #2563eb;
            --bg: #f5f7fb;
            --text: #172554;
            --muted: #64748b;
            --border: #e8edf5;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 30px;
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .container { max-width: 1200px; margin: auto; }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h1 { margin: 0 0 7px; font-size: 26px; }

        .subtitle { color: var(--muted); font-size: 13px; }

        .button {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 9px;
            background: var(--blue);
            color: white;
            text-decoration: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }

        .button:hover { background: #1d4ed8; }

        .button.secondary {
            background: #e2e8f0;
            color: var(--text);
        }

        .button.secondary:hover { background: #cbd5e1; }

        .button.danger { background: #dc2626; }
        .button.danger:hover { background: #991b1b; }

        .panel {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: white;
            overflow-x: auto;
        }

        
.filter-form {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 20px;
    align-items: end;
}

.filter-field {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.filter-field label {
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
}

.filter-field input,
.filter-field select {
    width: 100%;
    min-height: 42px;
    padding: 10px 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    background: white;
    color: var(--text);
    font: inherit;
    font-size: 13px;
}

.filter-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

@media (max-width: 850px) {
    .filter-form {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 500px) {
    .filter-form {
        grid-template-columns: 1fr;
    }
}


        .alert, .error {
            margin-bottom: 18px;
            padding: 13px 15px;
            border-radius: 9px;
            font-size: 13px;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #f8fafc;
            color: var(--muted);
            font-size: 11px;
        }

        .number { font-weight: 750; color: var(--navy); }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            padding: 35px;
            text-align: center;
            color: var(--muted);
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
            flex-wrap: wrap;
        }

        .actions form { margin: 0; }

        .pagination { margin-top: 18px; }

        @media (max-width: 600px) {
            body { padding: 15px; }
            .panel { padding: 14px; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="top">
        <div>
            <h1>Transaksi Penjualan</h1>
            <div class="subtitle">
                Kelola dan pantau seluruh transaksi penjualan.
            </div>
        </div>

        <div style="display:flex;gap:9px;flex-wrap:wrap">
            <a href="{{ route('dashboard') }}" class="button secondary">
                Dashboard
            </a>

            <a href="{{ route('sales.create') }}" class="button">
                + Buat Penjualan
            </a>
        </div>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan kesalahan --}}
    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   
<div class="panel">

    <form action="{{ route('sales.index') }}" method="GET" class="filter-form">
        <div class="filter-field">
            <label for="search">Cari transaksi atau kasir</label>
            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nomor transaksi / nama kasir"
                maxlength="100"
            >
        </div>

        <div class="filter-field">
            <label for="start_date">Tanggal mulai</label>
            <input
                type="date"
                id="start_date"
                name="start_date"
                value="{{ request('start_date') }}"
            >
        </div>

        <div class="filter-field">
            <label for="end_date">Tanggal akhir</label>
            <input
                type="date"
                id="end_date"
                name="end_date"
                value="{{ request('end_date') }}"
            >
        </div>

        <div class="filter-field">
            <label for="status">Status penjualan</label>
            <select id="status" name="status">
                <option value="">Semua status</option>
                <option value="completed" @selected(request('status') === 'completed')>
                    Selesai
                </option>
                <option value="cancelled" @selected(request('status') === 'cancelled')>
                    Dibatalkan
                </option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="button">Cari / Filter</button>

            <a href="{{ route('sales.index') }}" class="button secondary">
                Reset
            </a>
        </div>
    </form>

    <table>

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nomor Transaksi</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td>
                            {{ $sales->firstItem() + $loop->index }}
                        </td>

                        <td class="number">
                            {{ $sale->sale_number }}
                        </td>

                        <td>
                            {{ $sale->sold_at?->format('d/m/Y H:i') ?? '-' }}
                        </td>

                        <td>
                            {{ $sale->user?->name ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format((float) $sale->total, 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="status {{ $sale->status === 'cancelled' ? 'cancelled' : '' }}">
                                {{ $sale->status === 'completed' ? 'Selesai' : ($sale->status === 'cancelled' ? 'Dibatalkan' : ucfirst($sale->status)) }}
                            </span>
                        </td>

                        <td>
                            <div class="actions">
                                <a class="button"
                                   href="{{ route('sales.show', $sale) }}">
                                    Detail
                                </a>

                                {{-- Tombol pembatalan khusus Admin/Owner --}}
                                @if (
                                    auth()->check()
                                    && in_array(auth()->user()->role, ['admin', 'owner'], true)
                                    && $sale->status === 'completed'
                                )
                                    <form
                                        action="{{ route('sales.destroy', $sale) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin membatalkan penjualan ini? Stok produk akan dikembalikan.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="button danger">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            Belum ada transaksi penjualan.
                            Klik “Buat Penjualan” untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $sales->links() }}
        </div>
    </div>

</div>
</body>
</html>
