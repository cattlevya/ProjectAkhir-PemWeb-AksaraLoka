<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'weight',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'stock' => 'integer',
            'weight' => 'integer',
        ];
    }

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $slug = Str::slug($product->name);
                $count = static::where('slug', 'like', $slug . '%')->count();
                $product->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    // === Relationships ===

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // === Scopes ===

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopePriceBetween($query, $min, $max)
    {
        if ($min) $query->where('price', '>=', $min);
        if ($max) $query->where('price', '<=', $max);
        return $query;
    }

    // === Accessors ===

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float)$this->price, 0, ',', '.');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->primaryImage;
        $path = $primary ? $primary->image_path : ($this->images->first()?->image_path);
        
        if ($path) {
            if (str_starts_with($path, 'http')) {
                return $path;
            } elseif (str_starts_with($path, '/')) {
                return asset($path);
            }
            return asset('storage/' . $path);
        }
        
        return asset('images/default-product.png');
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
