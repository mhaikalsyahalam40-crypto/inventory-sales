<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    /**
     * Menampilkan laporan penjualan dengan pencarian dan filter tanggal.
     */
    public function index(Request $request)
    {
        // Validasi filter laporan.
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        // Hanya transaksi penjualan yang selesai.
        $query = Sale::query()
            ->where('status', 'completed');

        // Pencarian berdasarkan nomor transaksi.
        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(
                'sale_number',
                'like',
                '%' . $search . '%'
            );
        }

        // Filter tanggal mulai.
        if (!empty($validated['start_date'])) {
            $query->whereDate(
                'sold_at',
                '>=',
                $validated['start_date']
            );
        }

        // Filter tanggal akhir.
        if (!empty($validated['end_date'])) {
            $query->whereDate(
                'sold_at',
                '<=',
                $validated['end_date']
            );
        }

        // Ringkasan mengikuti pencarian dan filter yang digunakan.
        $totalTransactions = (clone $query)->count();

        $totalRevenue = (clone $query)->sum('total');

        // Ambil data beserta informasi kasir.
        $sales = (clone $query)
            ->with('user')
            ->orderByDesc('sold_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('reports.sales', compact(
            'sales',
            'totalTransactions',
            'totalRevenue'
        ));
    }
}
