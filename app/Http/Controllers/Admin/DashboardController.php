<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $newOrdersCount = Order::whereDate('created_at', today())->count();

        $todaysRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        $newCustomersCount = User::where('role', 'customer')
            ->whereDate('created_at', today())
            ->count();

        $totalProducts = Product::count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'newOrdersCount',
            'todaysRevenue',
            'newCustomersCount',
            'totalProducts',
            'recentOrders'
        ));
    }
}
