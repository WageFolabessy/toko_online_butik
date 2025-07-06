<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $productsQuery = Product::with(['category', 'images']);

        if ($request->filled('kategori')) {
            $productsQuery->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->kategori);
            });
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $productsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $sort = $request->input('sort', 'terbaru');

        if ($sort === 'harga-terendah') {
            $productsQuery->orderBy(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END'), 'asc');
        } elseif ($sort === 'harga-tertinggi') {
            $productsQuery->orderBy(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE price END'), 'desc');
        } else {
            $productsQuery->latest();
        }

        $products = $productsQuery->paginate(12)->withQueryString();

        return view('customer.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants', 'images', 'reviews.user']);

        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('customer.products.show', compact('product', 'relatedProducts'));
    }
}
