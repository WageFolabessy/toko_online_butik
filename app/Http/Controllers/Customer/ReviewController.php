<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_item_id' => 'required|exists:order_items,id|unique:product_reviews,order_item_id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $orderItem = OrderItem::find($data['order_item_id']);

        if ($orderItem->order->user_id !== auth()->id()) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        ProductReview::create([
            'user_id' => auth()->id(),
            'product_id' => $data['product_id'],
            'order_item_id' => $data['order_item_id'],
            'rating' => $data['rating'],
            'review' => $data['review'],
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function update(Request $request, ProductReview $review)
    {
        Gate::authorize('update', $review);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $review->update($data);
        return back()->with('success', 'Ulasan Anda berhasil diperbarui.');
    }

    public function destroy(ProductReview $review)
    {
        Gate::authorize('destroy', $review);
        $review->delete();
        return back()->with('success', 'Ulasan Anda berhasil dihapus.');
    }
}
