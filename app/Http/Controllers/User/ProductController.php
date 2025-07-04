<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::with('category', 'images');

        $this->applyFilters($request, $productsQuery);

        $products = $productsQuery->paginate(12)->withQueryString();

        $categories = Category::has('products')->get();

        return view('user.products.index', [
            'products' => $products,
            'categories' => $categories,
            'pageTitle' => 'Semua Produk',
        ]);
    }

    public function showByCategory(Request $request, Category $category)
    {
        $productsQuery = $category->products()->with('images');

        $this->applyFilters($request, $productsQuery);

        $products = $productsQuery->paginate(12)->withQueryString();

        $categories = Category::has('products')->get();

        return view('user.products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category,
            'pageTitle' => 'Kategori: ' . $category->name,
        ]);
    }

    protected function applyFilters(Request $request, $query)
    {
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'price_asc':
                    $query->orderByRaw('IF(discount_price > 0, discount_price, price) ASC');
                    break;
                case 'price_desc':
                    $query->orderByRaw('IF(discount_price > 0, discount_price, price) DESC');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
    }

    public function show(Product $product)
    {
        $product->load('category', 'images', 'variants');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}
