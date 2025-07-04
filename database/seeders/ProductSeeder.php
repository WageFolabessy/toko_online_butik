<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $directory = 'products';
        Storage::disk('public')->makeDirectory($directory);

        $bajuAtasanCategory = Category::where('slug', 'baju-atasan')->first();
        $celanaCategory = Category::where('slug', 'celana')->first();

        // Data Produk
        $productsData = [
            [
                'category' => $bajuAtasanCategory,
                'name' => 'Kemeja Flanel Kotak',
                'description' => 'Kemeja flanel lengan panjang dengan bahan katun premium yang nyaman dipakai sehari-hari.',
                'price' => 185000,
                'weight' => 250,
                'variants' => [
                    ['name' => 'S', 'stock' => 10],
                    ['name' => 'M', 'stock' => 15],
                    ['name' => 'L', 'stock' => 12],
                ],
            ],
            [
                'category' => $celanaCategory,
                'name' => 'Celana Chino Slim Fit',
                'description' => 'Celana chino model slim fit dengan bahan katun twill stretch yang fleksibel.',
                'price' => 220000,
                'weight' => 300,
                'variants' => [
                    ['name' => 'S', 'stock' => 20],
                    ['name' => 'M', 'stock' => 8],
                    ['name' => 'L', 'stock' => 5],
                ],
            ],
        ];

        foreach ($productsData as $data) {
            $product = Product::create([
                'category_id' => $data['category']->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'weight' => $data['weight'],
            ]);

            $product->variants()->createMany($data['variants']);

            $numberOfImages = 3;
            for ($i = 1; $i <= $numberOfImages; $i++) {
                $imageText = $product->name . ' #' . $i;
                $imageUrl = 'https://placehold.co/640x480.png?text=' . urlencode($imageText);
                $imageContent = @file_get_contents($imageUrl);

                if ($imageContent) {
                    $filename = Str::random(15) . '.png';
                    $path = $directory . '/' . $filename;
                    Storage::disk('public')->put($path, $imageContent);

                    $product->images()->create([
                        'path' => $path,
                    ]);
                }
            }
        }
    }
}
