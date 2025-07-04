<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $directory = 'banners';
        Storage::disk('public')->makeDirectory($directory);

        $text = 'Promo Butik Disel';
        $imageUrl = 'https://placehold.co/1200x400.png?text=' . urlencode($text);
        $imageContent = @file_get_contents($imageUrl);

        if ($imageContent) {
            $filename = Str::random(15) . '.png';
            $path = $directory . '/' . $filename;
            Storage::disk('public')->put($path, $imageContent);

            Banner::create([
                'image_path' => $path,
                'is_active' => true,
            ]);
        }
    }
}
