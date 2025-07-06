<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        DB::beginTransaction();
        try {
            $product = Product::create($data);

            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    $product->variants()->create($variant);
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $image) {
                    $imageName = md5(now() . $key) . '.' . $image->extension();
                    $image->storeAs('public/products', $imageName);
                    $product->images()->create([
                        'path' => $imageName,
                        'is_primary' => $key === 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('variants', 'images'); // Load relasi
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        DB::beginTransaction();
        try {
            $product->update($data);

            $product->variants()->delete();
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {
                    $product->variants()->create($variant);
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $image) {
                    $imageName = md5(now() . $key) . '.' . $image->extension();
                    $image->storeAs('public/products', $imageName);
                    $product->images()->create([
                        'path' => $imageName,
                        'is_primary' => !$product->images()->where('is_primary', true)->exists() && $key === 0
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            foreach ($product->images as $image) {
                Storage::delete('public/products/' . $image->path);
            }
            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
