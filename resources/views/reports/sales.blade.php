<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan | Nexora Tech</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fb;
            color: #172554;
        }

        .container {
            max-width: 1250px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .subtitle {
            color: #64748b;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            border: none;
            border-radius: 9px;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .button-blue {
            background: #2563eb;
            color: white;
        }

        .button-light {
            background: #e2e8f0;
            color: #172554;
        }

        .button-small {
            padding: 8px 12px;
            font-size: 12px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 22px;
        }

        .summary-card,
        .panel {
            background: white;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #e2e8f0;
        }

        .summary-label {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .summary-value {
            color: #1e3a8a;
            font-size: 27px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .filters {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr auto auto;
            gap: 12px;
            align-items: end;
            margin-bottom: 22px;
        }

        .field label {
            display: block;
            font-size: 13px;
            color: #475569;
            margin-bottom: 7px;
        }

        .field input {
            width: 100%;
            min-height: 43px;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        th {
            background: #f8fafc;
            color: #64748b;
            text-align: left;
            font-size: 12px;
            padding: 15px 12px;
            white-space: nowrap;
        }

        td {
            border-top: 1px solid #e2e8f0;
            padding: 16px 12px;
            font-size: 13px;
            vertical-align: middle;
        }

        .amount {
            font-weight: bold;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            border-radius: 20px;
            padding: 6px 10px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 35px 15px;
            color: #64748b;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }

        .pagination-links {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .pagination-links a,
        .pagination-links span {
            display: inline-block;
            padding: 8px 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: white;
            color: #1e3a8a;
            text-decoration: none;
        }

        .pagination-links .active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .pagination-links .disabled {
            color: #94a3b8;
        }

        .back-link {
            display: inline-block;
            margin-top: 22px;
            color: #2563eb;
            text-decoration: none;
        }

        .validation-error {
            color: #b91c1c;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .print-heading {
            display: none;
        }

        @media (max-width: 850px) {
            body {
                padding: 16px;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .filters {
                grid-template-columns: 1fr 1fr;
            }

            .filters .field:first-child {
                grid-column: 1 / -1;
            }

            .header h1 {
                font-size: 25px;
            }
        }

        @media (max-width: 480px) {
            .filters {
                grid-template-columns: 1fr;
            }

            .filters .field:first-child {
                grid-column: auto;
            }
        }

        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: #ffffff;
                color: #000000;
                font-size: 11px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .container {
                width: 100%;
                max-width: none;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }

            .print-heading {
                display: block;
                margin-bottom: 18px;
                text-align: center;
            }

            .print-heading h2 {
                margin: 0 0 6px;
                font-size: 21px;
            }

            .print-heading p {
                margin: 4px 0;
                font-size: 11px;
            }

            .header {
                margin-bottom: 15px;
            }

            h1 {
                font-size: 22px;
                color: #000000;
            }

            .subtitle {
                color: #333333;
            }

            .summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 12px;
            }

            .summary-card,
            .panel {
                padding: 12px;
                border: 1px solid #cccccc;
                border-radius: 0;
                box-shadow: none;
                background: #ffffff;
            }

            .summary-label {
                color: #444444;
                margin-bottom: 6px;
            }

            .summary-value {
                color: #000000;
                font-size: 19px;
            }

            .filters {
                display: none !important;
            }

            .table-wrapper {
                overflow: visible;
            }

            table {
                width: 100%;
                min-width: 0;
                table-layout: auto;
            }

            thead {
                display: table-header-group;
            }

            th {
                padding: 8px 6px;
                background: #eeeeee !important;
                color: #000000;
                border-bottom: 1px solid #999999;
                font-size: 10px;
            }

            td {
                padding: 8px 6px;
                color: #000000;
                font-size: 10px;
                overflow-wrap: anywhere;
            }

            tr {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .status {
                background: #eeeeee !important;
                color: #000000;
                border: 1px solid #999999;
                padding: 4px 7px;
            }

            .empty {
                color: #333333;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="print-heading">
        <h2>LAPORAN PENJUALAN</h2>
        <p>Inventory Sales Management System</p>
        <p>
            Dicetak pada:
            {{ now()->format('d/m/Y H:i') }}
        </p>

        @if (request('start_date') || request('end_date'))
            <p>
                Periode:
                {{ request('start_date') ? \Illuminate\Support\Carbon::parse(request('start_date'))->format('d/m/Y') : 'Awal' }}
                -
                {{ request('end_date') ? \Illuminate\Support\Carbon::parse(request('end_date'))->format('d/m/Y') : 'Sekarang' }}
            </p>
        @endif

        @if (request('search'))
            <p>Nomor transaksi dicari: {{ request('search') }}</p>
        @endif
    </div>

    <div class="header">
        <div>
            <h1>Laporan Penjualan</h1>
            <p class="subtitle">
                Ringkasan transaksi penjualan berdasarkan periode.
            </p>
        </div>

        <div class="header-actions no-print">
            <button
                type="button"
                class="button button-blue"
                onclick="window.print()"
            >
                Cetak Laporan
            </button>

            <a href="{{ route('sales.index') }}"
               class="button button-light">
                Daftar Penjualan
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="validation-error no-print">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="summary">
        <div class="summary-card">
            <div class="summary-label">Jumlah Transaksi</div>
            <div class="summary-value">
                {{ number_format($totalTransactions, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Total Omzet</div>
            <div class="summary-value">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="panel">
        <form
            method="GET"
            action="{{ route('reports.sales') }}"
            class="filters no-print"
        >
            <div class="field">
                <label for="search">Nomor Transaksi</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Contoh: SO-2026..."
                >
            </div>

            <div class="field">
                <label for="start_date">Dari Tanggal</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                >
            </div>

            <div class="field">
                <label for="end_date">Sampai Tanggal</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                >
            </div>

            <button type="submit" class="button button-blue">
                Terapkan
            </button>

            <a
                href="{{ route('reports.sales') }}"
                class="button button-light"
            >
                Reset
            </a>
        </form>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Penjualan</th>
                        <th>Status</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>
                                {{ $sales->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $sale->sale_number }}</strong>
                            </td>

                            <td>
                                {{ $sale->sold_at
                                    ? \Illuminate\Support\Carbon::parse($sale->sold_at)->format('d/m/Y H:i')
                                    : '-' }}
                            </td>

                            <td class="amount">
                                Rp {{ number_format($sale->total, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status">Selesai</span>
                            </td>

                            <td class="no-print">
                                <a
                                    href="{{ route('sales.show', $sale) }}"
                                    class="button button-blue button-small"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada transaksi yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination no-print">
            <div>
                @if ($sales->total() > 0)
                    Menampilkan {{ $sales->firstItem() }}
                    sampai {{ $sales->lastItem() }}
                    dari {{ $sales->total() }} transaksi
                @else
                    Tidak ada transaksi
                @endif
            </div>

            <div class="pagination-links">
                @if ($sales->onFirstPage())
                    <span class="disabled">Sebelumnya</span>
                @else
                    <a href="{{ $sales->previousPageUrl() }}">
                        Sebelumnya
                    </a>
                @endif

                @if ($sales->hasMorePages())
                    <a href="{{ $sales->nextPageUrl() }}">
                        Berikutnya
                    </a>
                @else
                    <span class="disabled">Berikutnya</span>
                @endif
            </div>
        </div>
    </div>

    <a
        href="{{ route('dashboard') }}"
        class="back-link no-print"
    >
        &larr; Kembali ke Dashboard
    </a>

</div>
</body>
</html>