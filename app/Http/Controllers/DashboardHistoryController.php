<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\DetailSale;
use Illuminate\Http\Request;

class DashboardHistoryController extends Controller
{
    public function history()
{
    // Get all completed transactions for the authenticated user
    $sales = Sale::where('user_id', auth()->user()->id)
                ->where('status', 1)
                ->get();

    // Pass the sales to the view
    return view('dashboard.dashboard_history.dashboard_history_index', compact('sales'));
}

}
