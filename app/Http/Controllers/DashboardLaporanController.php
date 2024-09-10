<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardLaporanController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));

        // Parse the selected month into a Carbon date
        $startDate = Carbon::parse($selectedMonth . '-01');
        
        // End date: today if current month, or end of the selected month
        $endDate = $startDate->copy()->endOfMonth();
        if ($selectedMonth === Carbon::now()->format('Y-m')) {
            $endDate = Carbon::now(); // Limit to today if the current month
        }

        // Fetch sales for the authenticated user within the selected month and load user relationships
        $sales = Sale::with('user') // Eager load the user relationship
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 1)
                    ->get()
                    ->groupBy(function ($sale) {
                        // Group sales by day (Y-m-d format)
                        return Carbon::parse($sale->created_at)->format('Y-m-d');
                    });

        // Hitung total harga untuk bulan ini
        $totalKeuntunganBulanIni = Sale::whereBetween('created_at', [$startDate, $endDate])
                                        ->where('status', 1)
                                        ->sum('total_harga');
        
        // Generate all dates for the month (from 1st to today or end of month)
        $dates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        // Pass the sales data, total price, and dates to the view
        return view('dashboard.dashboard_laporan.dashboard_laporan_index', compact('sales', 'dates', 'selectedMonth', 'totalKeuntunganBulanIni'));
    }
}
