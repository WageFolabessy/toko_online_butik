<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    public function index()
    {
        $cart = ShoppingCart::where('user_id', auth()->id())
            ->with('items.product.images', 'items.variant')
            ->first();

        $subtotal = 0;
        if ($cart) {
            foreach ($cart->items as $item) {
                $price = $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price;
                $subtotal += $price * $item->qty;
            }
        }

        return view('customer.cart.index', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $variant = Variant::find($request->variant_id);

        if ($variant->stock < $request->quantity) {
            return response()->json(['error' => 'Stok tidak mencukupi.'], 422);
        }

        try {
            DB::beginTransaction();
            $cart = ShoppingCart::firstOrCreate(['user_id' => $user->id]);

            $cartItem = $cart->items()
                ->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('qty', $request->quantity);
            } else {
                $cart->items()->create([
                    'product_id' => $request->product_id,
                    'variant_id' => $request->variant_id,
                    'qty' => $request->quantity,
                ]);
            }
            DB::commit();

            $cartCount = $cart->items()->sum('qty');

            return response()->json([
                'success' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan, silakan coba lagi.'], 500);
        }
    }

    public function update(Request $request, ShoppingCartItem $shoppingCartItem)
    {
        Gate::authorize('update', $shoppingCartItem);

        $request->validate(['quantity' => 'required|integer|min:1']);

        $shoppingCartItem->update(['qty' => $request->quantity]);

        $cart = $shoppingCartItem->shoppingCart;
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $item->load('product');
            $price = $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price;
            $subtotal += $price * $item->qty;
        }

        return response()->json([
            'success' => true,
            'cartCount' => $cart->items()->sum('qty'),
            'newSubtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
        ]);
    }

    public function destroy(ShoppingCartItem $shoppingCartItem)
    {
        Gate::authorize('delete', $shoppingCartItem);

        $cart = $shoppingCartItem->shoppingCart;
        $shoppingCartItem->delete();

        $subtotal = 0;
        foreach ($cart->items()->get() as $item) {
            $price = $item->product->discount_price > 0 ? $item->product->discount_price : $item->product->price;
            $subtotal += $price * $item->qty;
        }

        return response()->json([
            'success' => true,
            'cartCount' => $cart->items()->sum('qty'),
            'newSubtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
        ]);
    }
}
