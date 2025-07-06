<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'slug',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = self::generateSlug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = self::generateSlug($category->name);
        });
    }

    private static function generateSlug($name)
    {
        $slug = Str::slug($name);

        $count = Category::whereRaw("slug RLIKE '^{$slug}(.[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
