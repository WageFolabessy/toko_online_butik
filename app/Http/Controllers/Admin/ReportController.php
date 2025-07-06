<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $orders = Order::with('user')
            ->whereIn('status', ['pending', 'processed', 'shipped', 'completed', 'ready_for_pickup'])
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        return view('admin.reports.index', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'startDate',
            'endDate'
        ));
    }
}
