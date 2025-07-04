<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'images', 'variants')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $product = Product::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'description' => $validated['description'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? 0,
                'weight' => $validated['weight'],
            ]);

            if ($request->hasFile('images')) {
                foreach ($validated['images'] as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }

            foreach ($validated['variants']['name'] as $key => $name) {
                $product->variants()->create([
                    'name' => $name,
                    'stock' => $validated['variants']['stock'][$key],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Product $product)
    {
        $product->load('category', 'images', 'variants');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();

        $product->load('images', 'variants');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $slug = Str::slug($validated['name']);
            if (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $slug . '-' . $product->id;
            }

            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'slug' => $slug,
                'description' => $validated['description'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? 0,
                'weight' => $validated['weight'],
            ]);

            if ($request->hasFile('images')) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage->path);
                }
                $product->images()->delete();

                foreach ($validated['images'] as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
            }

            $product->variants()->delete();
            foreach ($validated['variants']['name'] as $key => $name) {
                $product->variants()->create([
                    'name' => $name,
                    'stock' => $validated['variants']['stock'][$key],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->path);
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }
}
