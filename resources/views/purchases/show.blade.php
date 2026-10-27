<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian</title>

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
            max-width: 1100px;
            margin: auto;
            padding: 28px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0000000d;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        h1 { margin: 0; color: #1e3a8a; }

        h2 {
            margin-top: 0;
            color: #1e3a8a;
            font-size: 18px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover { background: #1e40af; }

        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #991b1b; }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-card {
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; }

        .info-value {
            text-align: right;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
        }

        .status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 650px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #1e3a8a;
            color: white;
        }

        tfoot td {
            font-weight: bold;
            background: #eff6ff;
        }

        .total {
            text-align: right;
            color: #1e3a8a;
            font-size: 18px;
        }

        .notice {
            margin-top: 20px;
            padding: 12px 15px;
            border-radius: 8px;
            background: #fef2f2;
            color: #991b1b;
            font-size: 14px;
        }

        @media (max-width: 650px) {
            body { padding: 12px; }
            .container { padding: 18px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Detail Pembelian</h1>
            <p style="color:#64748b;">
                Informasi transaksi dan rincian barang.
            </p>
        </div>

        <a href="{{ route('purchases.index') }}" class="btn">
            Kembali ke Daftar
        </a>
    </div>

    {{-- Pesan sukses atau kesalahan --}}
    @if (session('success'))
        <div style="margin-bottom:20px;padding:12px;background:#dcfce7;color:#166534;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="margin-bottom:20px;padding:12px;background:#fee2e2;color:#991b1b;border-radius:8px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="margin-bottom:20px;padding:12px;background:#fee2e2;color:#991b1b;border-radius:8px;">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="info-grid">
        <div class="info-card">
            <h2>Informasi Transaksi</h2>

            <div class="info-row">
                <span class="info-label">Nomor Pembelian</span>
                <span class="info-value">
                    {{ $purchase->purchase_number }}
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-value">
                    {{ $purchase->purchased_at?->format('d-m-Y H:i') ?? '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="status {{ $purchase->status === 'cancelled' ? 'cancelled' : '' }}">
                        {{ $purchase->status === 'completed' ? 'Selesai' : ($purchase->status === 'cancelled' ? 'Dibatalkan' : ucfirst($purchase->status)) }}
                    </span>
                </span>
            </div>
        </div>

        <div class="info-card">
            <h2>Informasi Supplier</h2>

            <div class="info-row">
                <span class="info-label">Nama Supplier</span>
                <span class="info-value">
                    {{ $purchase->supplier->name ?? '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Telepon</span>
                <span class="info-value">
                    {{ $purchase->supplier->phone ?? '-' }}
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Petugas</span>
                <span class="info-value">
                    {{ $purchase->user->name ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <h2>Rincian Barang</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>SKU</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($purchase->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->sku ?? '-' }}</td>
                        <td>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</td>
                        <td>{{ number_format($item->quantity, 0, ',', '.') }}</td>
                        <td>
                            Rp {{ number_format((float) $item->unit_cost, 0, ',', '.') }}
                        </td>
                        <td>
                            Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">
                            Tidak ada rincian barang pada transaksi ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="5" class="total">Total Pembelian</td>
                    <td class="total">
                        Rp {{ number_format((float) $purchase->total, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="actions">
        <a href="{{ route('purchases.index') }}" class="btn">
            Kembali
        </a>

        {{-- Tombol pembatalan hanya untuk Admin dan Owner --}}
        @if (
            auth()->check()
            && in_array(auth()->user()->role, ['admin', 'owner'], true)
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
                    Batalkan Pembelian
                </button>
            </form>
        @endif
    </div>

    @if ($purchase->status === 'cancelled')
        <div class="notice">
            Transaksi pembelian ini sudah dibatalkan. Pembatalan tidak dapat dilakukan kembali.
        </div>
    @endif

</div>
</body>
</html>
