<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan | Nexora Tech</title>

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

        .container { max-width: 1100px; margin: auto; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h1 { margin: 0 0 7px; font-size: 26px; }
        h2 { font-size: 16px; }

        .muted { color: var(--muted); font-size: 13px; }

        .button {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 9px;
            background: var(--blue);
            color: white;
            text-decoration: none;
            border: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
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
            margin-bottom: 20px;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .info-label {
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 12px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 11px;
        }

        .status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
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

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-top: 20px;
            padding: 20px;
            border-radius: 12px;
            background: #eff6ff;
        }

        .total strong {
            color: var(--navy);
            font-size: 25px;
        }

        .alert {
            margin-bottom: 20px;
            padding: 13px 16px;
            border-radius: 9px;
            font-size: 13px;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
        }

        .alert.error {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 650px) {
            body { padding: 15px; }
            .panel { padding: 16px; }
            .info-grid { grid-template-columns: 1fr; }
            .total strong { font-size: 20px; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Detail Penjualan</h1>
            <div class="muted">
                Informasi lengkap transaksi penjualan.
            </div>
        </div>

        <a href="{{ route('sales.index') }}" class="button secondary">
            ← Kembali ke Penjualan
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan kesalahan --}}
    @if (session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert error">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <h2>Informasi Transaksi</h2>

        <div class="info-grid">
            <div>
                <div class="info-label">Nomor Transaksi</div>
                <div class="info-value">{{ $sale->sale_number }}</div>
            </div>

            <div>
                <div class="info-label">Tanggal Penjualan</div>
                <div class="info-value">
                    {{ $sale->sold_at?->format('d/m/Y H:i') ?? '-' }}
                </div>
            </div>

            <div>
                <div class="info-label">Kasir</div>
                <div class="info-value">
                    {{ $sale->user?->name ?? '-' }}
                </div>
            </div>

            <div>
                <div class="info-label">Status</div>
                <div>
                    <span class="status {{ $sale->status === 'cancelled' ? 'cancelled' : '' }}">
                        {{ $sale->status === 'completed' ? 'Selesai' : ($sale->status === 'cancelled' ? 'Dibatalkan' : ucfirst($sale->status)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <h2>Barang yang Dijual</h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sale->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product?->sku ?? '-' }}</td>
                            <td>
                                {{ $item->product?->name ?? 'Produk tidak tersedia' }}
                            </td>
                            <td>
                                Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}
                            </td>
                            <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                            <td>
                                Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                Belum ada detail barang pada transaksi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="total">
            <div>
                <div class="muted">Total Penjualan</div>
                <strong>
                    Rp {{ number_format((float) $sale->total, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        <div class="actions" style="margin-top:20px;">
            <a href="{{ route('sales.index') }}" class="button secondary">
                Kembali ke Daftar
            </a>

            {{-- Tombol hanya tampil untuk Admin/Owner dan transaksi selesai --}}
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
                        Batalkan Penjualan
                    </button>
                </form>
            @endif
        </div>

        @if ($sale->status === 'cancelled')
            <div class="alert error" style="margin-top:20px;margin-bottom:0;">
                Transaksi ini sudah dibatalkan. Stok telah dikembalikan sesuai rincian transaksi dan pembatalan tidak dapat dilakukan kembali.
            </div>
        @endif
    </div>

</div>
</body>
</html>
