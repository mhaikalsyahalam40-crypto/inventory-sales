<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    /**
     * Menampilkan laporan pembelian dengan pencarian dan filter tanggal.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'start_date' => ['nullable', 'date'],
            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        // Hanya transaksi pembelian yang selesai.
        $query = Purchase::query()
            ->where('status', 'completed');

        // Pencarian berdasarkan nomor pembelian.
        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(
                'purchase_number',
                'like',
                '%' . $search . '%'
            );
        }

        // Filter tanggal mulai.
        if (!empty($validated['start_date'])) {
            $query->whereDate(
                'purchased_at',
                '>=',
                $validated['start_date']
            );
        }

        // Filter tanggal akhir.
        if (!empty($validated['end_date'])) {
            $query->whereDate(
                'purchased_at',
                '<=',
                $validated['end_date']
            );
        }

        // Ringkasan mengikuti hasil pencarian dan filter.
        $totalTransactions = (clone $query)->count();

        $totalPurchases = (clone $query)->sum('total');

        // Ambil data laporan beserta supplier.
        $purchases = (clone $query)
            ->with(['supplier', 'user'])
            ->orderByDesc('purchased_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('reports.purchases', compact(
            'purchases',
            'totalTransactions',
            'totalPurchases'
        ));
    }
}
