<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    // use SoftDeletes;
    protected $fillable = ['user_id', 'product_id', 'order_id', 'comment', 'rating'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Deleted User',
            'email' => 'deleted@example.com'
        ]);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => 'Deleted Product',
            'description' => 'This product is no longer available'
        ]);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withDefault([
            'id' => 0,
            'total_amount' => 0.00
        ]);
    }
}
