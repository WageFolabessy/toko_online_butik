<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua banner yang statusnya aktif
        $banners = Banner::where('is_active', true)->latest()->get();

        // Mengambil 8 produk terbaru
        $newProducts = Product::with('category', 'images')->latest()->take(8)->get();

        // Mengambil 8 produk unggulan secara acak (bisa disesuaikan dengan logika bisnis, misal: terlaris)
        $featuredProducts = Product::with('category', 'images')->inRandomOrder()->take(8)->get();

        return view('user.home', compact('banners', 'newProducts', 'featuredProducts'));
    }
}
