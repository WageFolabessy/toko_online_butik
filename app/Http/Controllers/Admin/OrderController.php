<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product.images', 'items.variant', 'address', 'payment', 'shipment', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->status = $request->input('status');
        $order->save();

        if ($order->status === 'shipped' && $request->filled('tracking_number')) {
            $order->shipment()->update([
                'tracking_number' => $request->input('tracking_number'),
                'status' => 'shipped',
            ]);
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
