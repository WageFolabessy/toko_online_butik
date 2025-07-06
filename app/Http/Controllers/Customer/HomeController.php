<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->latest()->get();

        $products = Product::with(['category', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $reviews = ProductReview::with(['user', 'product.images'])
            ->latest()
            ->take(3)
            ->get();

        return view('customer.home', compact('banners', 'products', 'reviews'));
    }
}
