<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->latest()
            ->paginate(10);

        return view('customer.profile.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        Gate::authorize('view', $order);

        $order->load('items.product.images', 'items.variant', 'address', 'payment', 'shipment');

        return view('customer.profile.orders.show', compact('order'));
    }
}
