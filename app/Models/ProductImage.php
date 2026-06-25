<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    // === Relationships ===

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // === Accessors ===

    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        } elseif (str_starts_with($this->image_path, '/')) {
            return asset($this->image_path);
        }
        return asset('storage/' . $this->image_path);
    }
}
