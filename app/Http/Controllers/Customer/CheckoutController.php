<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\ShoppingCart;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap as MidtransSnap;
use Midtrans\Notification as MidtransNotification;

class CheckoutController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds = config('midtrans.is_3ds');

        if (!config('midtrans.is_production')) {
            MidtransConfig::$overrideNotifUrl = config('midtrans.ngrok_url');
        }
    }

    public function index()
    {
        $user = auth()->user();
        $cart = ShoppingCart::where('user_id', $user->id)->with('items.product.images')->first();
        $addresses = $user->addresses()->latest()->get();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price;
            $subtotal += $price * $item->qty;
        }

        return view('customer.checkout.index', compact('cart', 'addresses', 'subtotal'));
    }

    public function calculateShippingCost(Request $request)
    {
        $request->validate(['address_id' => 'required|exists:addresses,id']);
        $apiKey = config('services.rajaongkir.api_key');
        $originPostalCode = config('services.rajaongkir.origin_postal_code');
        $apiUrl = 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost';
        if (empty($apiKey) || empty($originPostalCode)) {
            Log::error('Konfigurasi RajaOngkir tidak ditemukan.');
            return response()->json(['message' => 'Konfigurasi server pengiriman tidak lengkap.'], 500);
        }
        $address = Address::find($request->address_id);
        $cart = ShoppingCart::where('user_id', auth()->id())->with('items.product')->first();
        $totalWeight = $cart->items->sum(fn($item) => $item->product->weight * $item->qty);
        try {
            $couriers = ['jne', 'pos', 'tiki'];
            $allServices = [];
            foreach ($couriers as $courier) {
                $payload = ['origin' => $originPostalCode, 'destination' => $address->postal_code, 'weight' => $totalWeight, 'courier' => $courier];
                $response = Http::withHeaders(['key' => $apiKey])->withOptions(['query' => $payload])->post($apiUrl);
                if ($response->successful() && !empty($response->json('data'))) {
                    $allServices = array_merge($allServices, $response->json('data'));
                }
            }
            return response()->json($allServices, 200);
        } catch (\Exception $e) {
            Log::error('Error ongkir:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Gagal terhubung ke layanan pengiriman.'], 500);
        }
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:delivery,pickup',
            'address_id' => 'required_if:delivery_method,delivery|nullable|exists:addresses,id',
            'shipping_service' => 'required_if:delivery_method,delivery|string',
        ]);

        $user = auth()->user();
        $cart = ShoppingCart::where('user_id', $user->id)->with('items.product', 'items.variant')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Keranjang Anda kosong.'], 400);
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $midtransItems = [];
            foreach ($cart->items as $item) {
                $variant = Variant::lockForUpdate()->find($item->variant_id);
                if ($variant->stock < $item->qty) {
                    throw new \Exception("Stok produk {$item->product->name} - {$variant->name} tidak mencukupi.");
                }
                $price = $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price;
                $subtotal += $price * $item->qty;
                $midtransItems[] = ['id' => $item->variant_id, 'price' => (int)$price, 'quantity' => (int)$item->qty, 'name' => substr($item->product->name . ' (' . $item->variant->name . ')', 0, 50)];
            }
            $shippingCost = 0;
            $shippingData = null;
            if ($request->delivery_method === 'delivery') {
                $shippingData = explode('|', $request->shipping_service);
                $shippingCost = (int)$shippingData[1];
                $midtransItems[] = ['id' => 'SHIPPING', 'price' => $shippingCost, 'quantity' => 1, 'name' => 'Ongkos Kirim'];
            }
            $totalAmount = $subtotal + $shippingCost;
            $orderNumber = 'ORD-' . time() . Str::upper(Str::random(5));
            $order = Order::create(['user_id' => $user->id, 'order_number' => $orderNumber, 'delivery_method' => $request->delivery_method, 'address_id' => $request->delivery_method === 'delivery' ? $request->address_id : null, 'total_amount' => $totalAmount, 'shipping_cost' => $shippingCost, 'status' => 'awaiting_payment']);
            foreach ($cart->items as $item) {
                $order->items()->create(['product_id' => $item->product_id, 'variant_id' => $item->variant_id, 'qty' => $item->qty, 'price' => $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price]);
            }
            if ($request->delivery_method === 'delivery' && $shippingData) {
                Shipment::create(['order_id' => $order->id, 'courier' => trim(explode('(', $shippingData[0])[0]), 'service' => trim(explode('(', $shippingData[0])[1], ' )'), 'shipping_cost' => $shippingCost]);
            }
            $midtransParams = ['transaction_details' => ['order_id' => $orderNumber, 'gross_amount' => (int)$totalAmount], 'customer_details' => ['first_name' => $user->name, 'email' => $user->email], 'item_details' => $midtransItems];
            $snapToken = MidtransSnap::getSnapToken($midtransParams);
            $cart->items()->delete();
            $cart->delete();
            DB::commit();
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Place Order Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memproses pesanan: ' . $e->getMessage()], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        try {
            $notification = new MidtransNotification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Exception: ' . $e->getMessage(), ['payload' => $request->all()]);
            return response()->json(['message' => 'Invalid notification object.'], 400);
        }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        Log::info("Notifikasi Midtrans diterima untuk Order #{$orderId} dengan status: {$transactionStatus}");

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) {
            Log::warning("Order #{$orderId} tidak ditemukan untuk notifikasi Midtrans.");
            return response()->json(['message' => 'Order not found.'], 200);
        }

        if ($order->status !== 'awaiting_payment') {
            Log::info("Notifikasi untuk order #{$orderId} diterima tapi status sudah bukan 'awaiting_payment'. Dilewati.");
            return response()->json(['message' => 'Order status already updated.'], 200);
        }

        DB::beginTransaction();
        try {
            Payment::updateOrCreate(
                ['transaction_id' => $notification->transaction_id],
                [
                    'order_id' => $order->id,
                    'payment_type' => $notification->payment_type,
                    'status' => $transactionStatus,
                    'amount' => (int)$notification->gross_amount,
                    'metadata' => $request->all(),
                ]
            );

            if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                $order->status = 'pending';

                foreach ($order->items as $item) {
                    $variant = Variant::lockForUpdate()->find($item->variant_id);
                    if ($variant) {
                        $variant->decrement('stock', $item->qty);
                    }
                }
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->status = 'cancelled';
            }

            $order->save();
            DB::commit();

            Log::info("Notifikasi Midtrans untuk order #{$orderId} berhasil diproses. Status baru: {$order->status}");
            return response()->json(['message' => 'Notification processed.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal memproses notifikasi Midtrans untuk order #{$orderId}", ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to process notification.'], 500);
        }
    }
}
