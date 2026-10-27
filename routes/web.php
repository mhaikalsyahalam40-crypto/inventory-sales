<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman untuk Admin dan Staff yang Sudah Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        $today = now()->toDateString();
        $month = now()->month;
        $year = now()->year;

        // Ringkasan produk dan transaksi.
        $totalProducts = Product::count();

        $totalTransactions = Purchase::count() + Sale::count();

        // Penjualan hari ini.
        $salesToday = Sale::where('status', 'completed')
            ->whereDate('sold_at', $today)
            ->sum('total');

        // Penjualan bulan ini.
        $salesThisMonth = Sale::where('status', 'completed')
            ->whereMonth('sold_at', $month)
            ->whereYear('sold_at', $year)
            ->sum('total');

        // Pembelian hari ini.
        $purchasesToday = Purchase::where('status', 'completed')
            ->whereDate('purchased_at', $today)
            ->sum('total');

        // Pembelian bulan ini.
        $purchasesThisMonth = Purchase::where('status', 'completed')
            ->whereMonth('purchased_at', $month)
            ->whereYear('purchased_at', $year)
            ->sum('total');

        // Jumlah produk dengan stok rendah.
        $lowStock = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        // Lima produk dengan stok rendah.
        $products = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get();

        /*
         * Data grafik penjualan selama 12 bulan terakhir.
         */
        $startMonth = now()->startOfMonth()->subMonths(11);
        $endMonth = now()->endOfMonth();

        $salesByMonth = Sale::where('status', 'completed')
            ->whereBetween('sold_at', [$startMonth, $endMonth])
            ->selectRaw(
                'YEAR(sold_at) as year,
                 MONTH(sold_at) as month,
                 SUM(total) as total'
            )
            ->groupByRaw('YEAR(sold_at), MONTH(sold_at)')
            ->get()
            ->keyBy(fn ($sale) => $sale->year . '-' . $sale->month);

        $monthlySalesLabels = [];
        $monthlySalesData = [];

        for ($i = 0; $i < 12; $i++) {
            $date = $startMonth->copy()->addMonths($i);
            $key = $date->year . '-' . $date->month;

            $monthlySalesLabels[] = $date->translatedFormat('M Y');

            $monthlySalesData[] = (float) (
                $salesByMonth->get($key)?->total ?? 0
            );
        }

        /*
         * Data grafik stok untuk 10 produk terbanyak.
         */
        $stockChartProducts = Product::orderByDesc('stock')
            ->orderBy('name')
            ->limit(10)
            ->get(['name', 'stock']);

        $stockChartLabels = $stockChartProducts
            ->pluck('name')
            ->values()
            ->all();

        $stockChartData = $stockChartProducts
            ->pluck('stock')
            ->map(fn ($stock) => (int) $stock)
            ->values()
            ->all();

        return view('dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'salesToday',
            'salesThisMonth',
            'purchasesToday',
            'purchasesThisMonth',
            'lowStock',
            'products',
            'monthlySalesLabels',
            'monthlySalesData',
            'stockChartLabels',
            'stockChartData'
        ));
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Produk: Bisa Dilihat Admin dan Staff
    |--------------------------------------------------------------------------
    */

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

   
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')
    ->name('products.show');


    /*
    |--------------------------------------------------------------------------
    | Transaksi Pembelian
    |--------------------------------------------------------------------------
    | Daftar, formulir, penyimpanan, dan detail.
    | Pembatalan didefinisikan terpisah di grup Admin.
    */

    Route::resource('purchases', PurchaseController::class)
        ->only(['index', 'create', 'store', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Transaksi Penjualan
    |--------------------------------------------------------------------------
    */

    Route::resource('sales', SaleController::class)
        ->only(['index', 'create', 'store', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/reports/sales', [
        SalesReportController::class,
        'index',
    ])->name('reports.sales');

    Route::get('/reports/purchases', [
        PurchaseReportController::class,
        'index',
    ])->name('reports.purchases');
});

/*
|--------------------------------------------------------------------------
| Khusus Admin
|--------------------------------------------------------------------------
| Middleware role:admin harus memeriksa role pengguna di server.
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Manajemen kategori.
    Route::resource('categories', CategoryController::class)
        ->except(['show']);

    // Manajemen produk.
    Route::resource('products', ProductController::class)
        ->except(['index', 'show']);

    // Manajemen supplier.
    Route::resource('suppliers', SupplierController::class)
        ->except(['show']);

    // Manajemen pengguna dan role.
    Route::resource('users', UserController::class)
        ->except(['show']);

    // Pembatalan transaksi pembelian.
    Route::delete(
        '/purchases/{purchase}',
        [PurchaseController::class, 'destroy']
    )->name('purchases.destroy');

    // Pembatalan transaksi penjualan.
    Route::delete(
        '/sales/{sale}',
        [SaleController::class, 'destroy']
    )->name('sales.destroy');

    // Halaman administrasi.
    Route::get('/admin', function () {
        return redirect()->route('users.index');
    })->name('admin.dashboard');
});
