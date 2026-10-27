<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Dashboard | Nexora Tech</title>



    <style>

        :root {

            --navy: #1e3a8a;

            --blue: #2563eb;

            --bg: #f5f7fb;

            --text: #172554;

            --muted: #64748b;

            --border: #e8edf5;

            --white: #ffffff;

        }



        * {

            box-sizing: border-box;

        }



        body {

            margin: 0;

            font-family: "Segoe UI", Arial, sans-serif;

            background: var(--bg);

            color: var(--text);

        }



        a {

            -webkit-tap-highlight-color: transparent;

        }



        .layout {

            min-height: 100vh;

            display: flex;

        }



        /* SIDEBAR */

        .sidebar {

            position: fixed;

            inset: 0 auto 0 0;

            z-index: 5;

            display: flex;

            flex-direction: column;

            width: 255px;

            padding: 25px 16px;

            overflow-y: auto;

            color: white;

            background: var(--navy);

        }



        .brand {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 0 9px 30px;

            font-size: 17px;

            font-weight: 800;

        }



        .brand-icon {

            display: grid;

            place-items: center;

            width: 43px;

            height: 43px;

            flex-shrink: 0;

            border-radius: 12px;

            background: #ffffff24;

            font-size: 23px;

        }



        .brand small {

            display: block;

            margin-top: 4px;

            color: #bfdbfe;

            font-size: 10px;

            font-weight: 500;

            letter-spacing: .8px;

        }



        .nav-label {

            padding: 12px 12px 9px;

            color: #93c5fd;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.5px;

        }



        .nav-link {

            display: flex;

            align-items: center;

            gap: 13px;

            margin: 3px 0;

            padding: 12px;

            border-radius: 9px;

            color: #dbeafe;

            text-decoration: none;

            font-size: 13px;

            transition: background .2s;

        }



        .nav-link:hover,

        .nav-link.active {

            color: white;

            background: var(--blue);

        }



        .nav-icon {

            display: inline-grid;

            place-items: center;

            width: 22px;

            flex-shrink: 0;

            font-size: 17px;

        }



        .sidebar-bottom {

            margin-top: auto;

            padding-top: 20px;

        }



        .sidebar-note {

            padding: 15px;

            border: 1px solid #ffffff20;

            border-radius: 12px;

            background: #ffffff0b;

            color: #dbeafe;

            font-size: 12px;

            line-height: 1.7;

        }



        .logout-button {

            width: 100%;

            margin-top: 10px;

            padding: 11px;

            border: 1px solid #ffffff30;

            border-radius: 9px;

            background: transparent;

            color: white;

            cursor: pointer;

            text-align: left;

            font-size: 13px;

        }



        .logout-button:hover {

            background: #ffffff12;

        }



        /* KONTEN UTAMA */

        .main {

            width: calc(100% - 255px);

            min-width: 0;

            margin-left: 255px;

        }



        .topbar {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            min-height: 78px;

            padding: 15px 32px;

            border-bottom: 1px solid var(--border);

            background: white;

        }



        .breadcrumb {

            color: var(--muted);

            font-size: 12px;

        }



        .breadcrumb strong {

            color: var(--text);

        }



        .top-title {

            margin-top: 5px;

            font-size: 18px;

            font-weight: 750;

        }



        .profile {

            display: flex;

            align-items: center;

            gap: 11px;

        }



        .avatar {

            display: grid;

            place-items: center;

            width: 42px;

            height: 42px;

            border-radius: 13px;

            background: #dbeafe;

            color: var(--navy);

            font-weight: 800;

        }



        .profile-name {

            font-size: 12px;

            font-weight: 750;

        }



        .profile-role {

            margin-top: 4px;

            color: var(--muted);

            font-size: 11px;

        }



        .content {

            max-width: 1500px;

            margin: 0 auto;

            padding: 30px 32px;

        }



        .welcome {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            margin-bottom: 27px;

        }



        .welcome h1 {

            margin: 0 0 8px;

            font-size: 27px;

            letter-spacing: -.6px;

        }



        .welcome p {

            margin: 0;

            color: var(--muted);

            font-size: 13px;

        }



        .date-chip {

            padding: 11px 15px;

            border: 1px solid #dbeafe;

            border-radius: 10px;

            background: white;

            color: var(--navy);

            font-size: 12px;

            font-weight: 700;

            white-space: nowrap;

        }



        /* KARTU STATISTIK */

        .stats {

            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));

            gap: 18px;

        }



        .stat-card {

            min-width: 0;

            padding: 22px;

            border: 1px solid var(--border);

            border-radius: 14px;

            background: white;

            box-shadow: 0 4px 14px #1e3a8a06;

        }



        .stat-top {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;

            margin-bottom: 22px;

        }



        .stat-label {

            color: var(--muted);

            font-size: 12px;

            font-weight: 650;

        }



        .stat-icon {

            display: grid;

            place-items: center;

            width: 42px;

            height: 42px;

            flex-shrink: 0;

            border-radius: 12px;

            background: #eff6ff;

            color: var(--blue);

            font-size: 21px;

        }



        .stat-value {

            font-size: 25px;

            font-weight: 800;

            letter-spacing: -.5px;

            overflow-wrap: anywhere;

        }



        .stat-foot {

            margin-top: 8px;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.6;

        }



        /* PANEL */

        .section-grid {

            display: grid;

            grid-template-columns: minmax(0, 1.25fr) minmax(0, .75fr);

            gap: 18px;

            margin-top: 22px;

        }



        .panel {

            min-width: 0;

            padding: 23px;

            border: 1px solid var(--border);

            border-radius: 14px;

            background: white;

            box-shadow: 0 4px 14px #1e3a8a06;

        }



        .panel-heading {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;

            margin-bottom: 20px;

        }



        .panel-heading h2 {

            margin: 0;

            font-size: 15px;

        }



        .panel-heading span {

            color: var(--muted);

            font-size: 11px;

        }



        .table-wrap {

            overflow-x: auto;

        }



        table {

            width: 100%;

            border-collapse: collapse;

        }



        th, td {

            padding: 12px 8px;

            border-bottom: 1px solid var(--border);

            text-align: left;

            font-size: 12px;

        }



        th {

            color: var(--muted);

            background: #f8fafc;

            font-size: 11px;

        }



        .stock-name {

            font-weight: 700;

        }



        .stock-sku {

            margin-top: 4px;

            color: var(--muted);

            font-size: 10px;

        }



        .stock-badge {

            display: inline-block;

            padding: 5px 8px;

            border-radius: 20px;

            background: #dcfce7;

            color: #166534;

            font-size: 10px;

            font-weight: 750;

        }



        .stock-badge.low {

            background: #fee2e2;

            color: #991b1b;

        }



        .quick-links {

            display: grid;

            gap: 10px;

        }



        .quick-link {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 13px;

            border: 1px solid var(--border);

            border-radius: 10px;

            color: var(--text);

            text-decoration: none;

            transition: .2s;

        }



        .quick-link:hover {

            border-color: #bfdbfe;

            background: #f8fbff;

        }



        .quick-icon {

            display: grid;

            place-items: center;

            width: 38px;

            height: 38px;

            flex-shrink: 0;

            border-radius: 10px;

            background: #eff6ff;

            color: var(--blue);

            font-size: 18px;

        }



        .quick-link strong {

            display: block;

            font-size: 12px;

        }



        .quick-link small {

            display: block;

            margin-top: 4px;

            color: var(--muted);

            font-size: 11px;

            line-height: 1.5;

        }



        .empty {

            padding: 22px 10px;

            text-align: center;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.8;

        }



        .empty-icon {

            margin-bottom: 8px;

            color: #16a34a;

            font-size: 28px;

        }



        .text-link {

            color: var(--blue);

            text-decoration: none;

            font-weight: 700;

        }



        .text-link:hover {

            text-decoration: underline;

        }



        .footer {

            padding: 25px 0 5px;

            color: #94a3b8;

            font-size: 11px;

            text-align: center;

        }



        /* RESPONSIF */

        @media (max-width: 1200px) {

            .stats {

                grid-template-columns: repeat(2, minmax(0, 1fr));

            }



            .section-grid {

                grid-template-columns: 1fr;

            }

        }



        @media (max-width: 900px) {

            .sidebar {

                width: 220px;

            }



            .main {

                width: calc(100% - 220px);

                margin-left: 220px;

            }



            .content {

                padding: 25px 20px;

            }



            .topbar {

                padding: 15px 20px;

            }

        }



        @media (max-width: 650px) {

            .layout {

                display: block;

            }



            .sidebar {

                position: static;

                width: 100%;

                min-height: auto;

                padding: 16px;

                overflow: visible;

            }



            .brand {

                padding: 0 5px 14px;

            }



            .sidebar .nav-label {

                padding-top: 10px;

            }



            .sidebar .nav-link {

                padding: 10px;

            }



            .sidebar-bottom {

                margin-top: 10px;

                padding-top: 0;

            }



            .sidebar-note {

                display: none;

            }



            .main {

                width: 100%;

                margin: 0;

            }



            .topbar {

                padding: 14px 16px;

            }



            .content {

                padding: 22px 15px;

            }



            .welcome {

                align-items: flex-start;

                flex-direction: column;

            }



            .welcome h1 {

                font-size: 24px;

            }



            .stats {

                grid-template-columns: 1fr;

                gap: 12px;

            }



            .stat-card {

                padding: 18px;

            }



            .stat-value {

                font-size: 24px;

            }



            .profile-name {

                max-width: 110px;

                overflow-wrap: anywhere;

            }



            .panel {

                padding: 16px;

            }

        }



        /* GRAFIK DASHBOARD */
        .chart-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 18px;
            margin-top: 22px;
        }

        .chart-panel {
            min-width: 0;
            padding: 23px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: white;
            box-shadow: 0 4px 14px #1e3a8a06;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
        }

        @media (max-width: 1200px) {
            .chart-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 650px) {
            .chart-panel { padding: 16px; }
            .chart-container { height: 260px; }
        }

    </style>

</head>



<body>

<div class="layout">



    {{-- SIDEBAR --}}

    <aside class="sidebar">

        <div class="brand">

            <div class="brand-icon">▦</div>

            <div>

                Nexora Tech

                <small>Nexora Tech</small>

            </div>

        </div>



        <div class="nav-label">MENU UTAMA</div>



        <a href="{{ route('dashboard') }}" class="nav-link active">

            <span class="nav-icon">⌂</span>

            Dashboard

        </a>



        <div class="nav-label">MANAJEMEN INVENTORI</div>



        <a href="{{ route('products.index') }}" class="nav-link">

            <span class="nav-icon">▣</span>

            Produk

        </a>



        <a href="{{ route('categories.index') }}" class="nav-link">

            <span class="nav-icon">▦</span>

            Kategori

        </a>



        <a href="{{ route('suppliers.index') }}" class="nav-link">

            <span class="nav-icon">♧</span>

            Supplier

        </a>



        <div class="nav-label">TRANSAKSI</div>



        <a href="{{ route('purchases.index') }}" class="nav-link">

            <span class="nav-icon">↓</span>

            Pembelian

        </a>



        <a href="{{ route('sales.index') }}" class="nav-link">

            <span class="nav-icon">↑</span>

            Penjualan

        </a>



        <div class="nav-label">LAPORAN</div>



        <a href="{{ route('reports.sales') }}" class="nav-link">

            <span class="nav-icon">▤</span>

            Laporan Penjualan

        </a>



        <a href="{{ route('reports.purchases') }}" class="nav-link">

            <span class="nav-icon">▤</span>

            Laporan Pembelian

        </a>



        @if (auth()->user()->isAdmin())

            <div class="nav-label">PENGATURAN</div>



            <a href="{{ route('users.index') }}" class="nav-link">

                <span class="nav-icon">⚙</span>

                Pengguna

            </a>

        @endif



        <div class="sidebar-bottom">

            <div class="sidebar-note">

                <strong>Nexora Tech</strong><br>

                Kelola operasional bisnis dari satu tempat.

            </div>



            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button class="logout-button" type="submit">

                    ↪ &nbsp; Logout

                </button>

            </form>

        </div>

    </aside>



    {{-- KONTEN UTAMA --}}

    <main class="main">

        <header class="topbar">

            <div>

                <div class="breadcrumb">

                    Menu Utama / <strong>Dashboard</strong>

                </div>

                <div class="top-title">Dashboard Overview</div>

            </div>



            <div class="profile">

                <div class="avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div>

                    <div class="profile-name">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="profile-role">

                        {{ ucfirst(auth()->user()->role) }} Account

                    </div>

                </div>

            </div>

        </header>



        <div class="content">



            {{-- SAPAAN DAN TANGGAL --}}

            <section class="welcome">

                <div>

                    <h1>

                        Selamat datang, {{ auth()->user()->name }} 👋

                    </h1>

                    <p>

                        Berikut ringkasan sistem inventori dan penjualan Anda.

                    </p>

                </div>



                <div class="date-chip">

                    ▦ {{ now()->timezone('Asia/Jakarta')->format('d M Y') }}

                </div>

            </section>



            {{-- KARTU STATISTIK --}}

            <section class="stats">



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Total Produk</span>

                        <div class="stat-icon">▦</div>

                    </div>

                    <div class="stat-value">

                        {{ number_format($totalProducts, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Produk terdaftar di sistem

                    </div>

                </article>



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Total Transaksi</span>

                        <div class="stat-icon">▤</div>

                    </div>

                    <div class="stat-value">

                        {{ number_format($totalTransactions, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Jumlah transaksi pembelian dan penjualan

                    </div>

                </article>



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Stok Menipis</span>

                        <div class="stat-icon">⚠</div>

                    </div>

                    <div class="stat-value">

                        {{ number_format($lowStock, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Produk dengan stok di bawah atau sama dengan batas minimum

                    </div>

                </article>



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Penjualan Hari Ini</span>

                        <div class="stat-icon">↗</div>

                    </div>

                    <div class="stat-value">

                        Rp {{ number_format((float) $salesToday, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Penjualan berstatus selesai hari ini

                    </div>

                </article>



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Penjualan Bulan Ini</span>

                        <div class="stat-icon">↗</div>

                    </div>

                    <div class="stat-value">

                        Rp {{ number_format((float) $salesThisMonth, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Penjualan berstatus selesai bulan ini

                    </div>

                </article>



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Pembelian Hari Ini</span>

                        <div class="stat-icon">↙</div>

                    </div>

                    <div class="stat-value">

                        Rp {{ number_format((float) $purchasesToday, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Pembelian berstatus selesai hari ini

                    </div>

                </article>



                <article class="stat-card">

                    <div class="stat-top">

                        <span class="stat-label">Pembelian Bulan Ini</span>

                        <div class="stat-icon">↙</div>

                    </div>

                    <div class="stat-value">

                        Rp {{ number_format((float) $purchasesThisMonth, 0, ',', '.') }}

                    </div>

                    <div class="stat-foot">

                        Pembelian berstatus selesai bulan ini

                    </div>

                </article>



            </section>



            {{-- GRAFIK PENJUALAN DAN STOK PRODUK --}}
            <section class="chart-grid">
                <article class="chart-panel">
                    <div class="panel-heading">
                        <h2>Grafik Penjualan Bulanan</h2>
                        <span>12 bulan terakhir</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="monthlySalesChart" aria-label="Grafik total penjualan per bulan" role="img"></canvas>
                    </div>
                </article>

                <article class="chart-panel">
                    <div class="panel-heading">
                        <h2>Grafik Stok Produk</h2>
                        <span>10 produk dengan stok terbanyak</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="productStockChart" aria-label="Grafik jumlah stok produk" role="img"></canvas>
                    </div>
                </article>
            </section>

            {{-- RINGKASAN PERSEDIAAN DAN AKSES CEPAT --}}

            <section class="section-grid">



                <div class="panel">

                    <div class="panel-heading">

                        <h2>Ringkasan Persediaan</h2>

                        <a href="{{ route('products.index') }}" class="text-link">

                            Lihat semua

                        </a>

                    </div>



                    @if ($products->isEmpty())

                        <div class="empty">

                            <div class="empty-icon">✓</div>

                            Tidak ada produk dengan stok menipis.

                            <br>

                            Semua produk saat ini berada di atas batas stok minimum.

                            <br>

                            <a class="text-link" href="{{ route('products.index') }}">

                                Lihat semua produk

                            </a>

                        </div>

                    @else

                        <div class="table-wrap">

                            <table>

                                <thead>

                                    <tr>

                                        <th>Produk</th>

                                        <th>Kategori</th>

                                        <th>Stok</th>

                                        <th>Status</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($products as $product)

                                        <tr>

                                            <td>

                                                <div class="stock-name">

                                                    {{ $product->name }}

                                                </div>

                                                <div class="stock-sku">

                                                    {{ $product->sku }}

                                                </div>

                                            </td>

                                            <td>

                                                {{ $product->category?->name ?? '-' }}

                                            </td>

                                            <td>

                                                {{ number_format($product->stock, 0, ',', '.') }}

                                            </td>

                                            <td>

                                                @if ($product->stock <= $product->minimum_stock)

                                                    <span class="stock-badge low">

                                                        Stok menipis

                                                    </span>

                                                @else

                                                    <span class="stock-badge">

                                                        Aman

                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>



                <div class="panel">

                    <div class="panel-heading">

                        <h2>Akses Cepat</h2>

                        <span>Shortcut</span>

                    </div>



                    <div class="quick-links">



                        <a class="quick-link" href="{{ route('products.create') }}">

                            <span class="quick-icon">＋</span>

                            <span>

                                <strong>Tambah Produk</strong>

                                <small>Daftarkan produk baru</small>

                            </span>

                        </a>



                        <a class="quick-link" href="{{ route('purchases.create') }}">

                            <span class="quick-icon">↓</span>

                            <span>

                                <strong>Catat Pembelian</strong>

                                <small>Masukkan stok dari pemasok</small>

                            </span>

                        </a>



                        <a class="quick-link" href="{{ route('sales.create') }}">

                            <span class="quick-icon">↑</span>

                            <span>

                                <strong>Buat Penjualan</strong>

                                <small>Catat transaksi pelanggan</small>

                            </span>

                        </a>



                        <a class="quick-link" href="{{ route('reports.sales') }}">

                            <span class="quick-icon">▤</span>

                            <span>

                                <strong>Laporan Penjualan</strong>

                                <small>Lihat ringkasan transaksi penjualan</small>

                            </span>

                        </a>



                        <a class="quick-link" href="{{ route('reports.purchases') }}">

                            <span class="quick-icon">▤</span>

                            <span>

                                <strong>Laporan Pembelian</strong>

                                <small>Lihat ringkasan transaksi pembelian</small>

                            </span>

                        </a>



                    </div>

                </div>



            </section>



            <footer class="footer">

                © {{ now()->year }} Nexora Tech — Inventory &amp; Sales Management System.

                Seluruh hak cipta dilindungi.

            </footer>



        </div>

    </main>



</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(value || 0);

        const salesCanvas = document.getElementById('monthlySalesChart');
        if (salesCanvas) {
            new Chart(salesCanvas, {
                type: 'line',
                data: {
                    labels: @json($monthlySalesLabels),
                    datasets: [{
                        label: 'Total penjualan',
                        data: @json($monthlySalesData),
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (context) => rupiah(context.parsed.y) } }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { callback: (value) => rupiah(value) }
                        }
                    }
                }
            });
        }

        const stockCanvas = document.getElementById('productStockChart');
        if (stockCanvas) {
            new Chart(stockCanvas, {
                type: 'bar',
                data: {
                    labels: @json($stockChartLabels),
                    datasets: [{
                        label: 'Jumlah stok',
                        data: @json($stockChartData),
                        backgroundColor: 'rgba(37, 99, 235, 0.78)',
                        borderColor: '#1e3a8a',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });
        }
    });
</script>

</body>

</html>
