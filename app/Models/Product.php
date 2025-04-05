<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;


    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
        'deleted_at'  // Added for soft deletes
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    // Relationships
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'description' => 'Uncategorized'
        ]);
    }

    // Searchable configuration

    public function shouldBeSearchable()
    {
        return $this->exists && !$this->trashed();
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return (float)$this->reviews()->avg('rating') ?: 0;
    }

    public function getFormattedPriceAttribute()
    {
        return '$'.number_format($this->price, 2);
    }

    // Scopes
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeWithImages($query)
    {
        return $query->with(['images' => function($q) {
            $q->orderBy('created_at', 'desc');
        }]);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category_description' => $this->category->description ?? '',
        ];
    }
}
