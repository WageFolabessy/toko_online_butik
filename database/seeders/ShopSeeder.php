<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopSeeder extends Seeder
{
    private function saveImageFromUrl(string $url, string $directory): ?string
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $filename = Str::random(20) . '.png';
                $path = "public/{$directory}/{$filename}";
                Storage::put($path, $response->body());
                return $filename;
            }
        } catch (\Exception $e) {
            // Jika gagal, log error (opsional)
            return null;
        }
        return null;
    }

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Product::truncate();
        Category::truncate();
        Banner::truncate();
        DB::table('variants')->truncate();
        DB::table('product_images')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Storage::deleteDirectory('public/categories');
        Storage::deleteDirectory('public/products');
        Storage::deleteDirectory('public/banners');
        Storage::makeDirectory('public/categories');
        Storage::makeDirectory('public/products');
        Storage::makeDirectory('public/banners');

        $this->command->info('Truncating tables and clearing storage directories...');


        $categoriesData = ['Gaun', 'Blus', 'Kemeja', 'Rok', 'Celana', 'Jaket', 'Aksesoris'];
        $productAdjectives = ['Elegan', 'Kasual', 'Vintage', 'Modern', 'Minimalis', 'Bohemian'];
        $productMaterials = ['Katun Jepang', 'Sutra', 'Linen Rami', 'Denim', 'Sifon', 'Rajut Premium'];
        $productVariants = ['S', 'M', 'L', 'XL'];
        $bannersData = ['Sale Akhir Musim', 'Koleksi Terbaru Datang', 'Gratis Ongkir!'];


        $this->command->info('Seeding categories...');
        $createdCategories = [];
        foreach ($categoriesData as $catName) {
            $imageName = $this->saveImageFromUrl('https://placehold.co/600x600.png?text=' . urlencode($catName), 'categories');
            if ($imageName) {
                $category = Category::create([
                    'name' => $catName,
                    'slug' => Str::slug($catName),
                    'image' => $imageName,
                ]);
                $createdCategories[] = $category->id;
            }
        }


        $this->command->info('Seeding banners...');
        foreach ($bannersData as $bannerText) {
            $imageName = $this->saveImageFromUrl('https://placehold.co/1200x400.png?text=' . urlencode($bannerText), 'banners');
            if ($imageName) {
                Banner::create([
                    'image' => $imageName,
                    'is_active' => true,
                ]);
            }
        }


        $this->command->info('Seeding products, variants, and images...');
        for ($i = 0; $i < 20; $i++) {
            $adjective = $productAdjectives[array_rand($productAdjectives)];
            $material = $productMaterials[array_rand($productMaterials)];
            $category = Category::find($createdCategories[array_rand($createdCategories)]);

            $productName = "{$category->name} {$adjective} Bahan {$material}";

            $product = Product::create([
                'category_id' => $category->id,
                'name' => $productName,
                'slug' => Str::slug($productName) . '-' . Str::lower(Str::random(5)),
                'description' => "Ini adalah deskripsi untuk {$productName}. Dibuat dengan bahan kualitas terbaik untuk kenyamanan dan gaya maksimal. Cocok untuk berbagai acara, baik formal maupun santai.",
                'price' => rand(150000, 500000),
                'discount_price' => rand(0, 1) ? rand(100000, 149000) : 0,
                'weight' => rand(200, 800),
            ]);

            foreach ($productVariants as $variantName) {
                $product->variants()->create([
                    'name' => $variantName,
                    'stock' => rand(5, 50),
                ]);
            }

            for ($j = 0; $j < 3; $j++) {
                $imageText = Str::limit($product->name, 15);
                $imageName = $this->saveImageFromUrl('https://placehold.co/640x480.png?text=' . urlencode($imageText), 'products');
                if ($imageName) {
                    $product->images()->create([
                        'path' => $imageName,
                        'is_primary' => $j === 0,
                    ]);
                }
            }
        }

        $this->command->info('ShopSeeder finished successfully!');
    }
}
