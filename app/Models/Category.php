<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    // Auto-generate slug pada saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // === Relationships ===

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // === Helpers ===

    /**
     * Cek apakah kategori ini termasuk kelompok Wastra
     */
    public function isWastra(): bool
    {
        return in_array($this->slug, ['batik-banyumasan', 'tenun-lurik', 'kerajinan-tangan']);
    }

    /**
     * Cek apakah kategori ini termasuk kelompok Kuliner
     */
    public function isKuliner(): bool
    {
        return in_array($this->slug, ['makanan-khas', 'minuman-tradisional']);
    }
}
