<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'type',
        'qty',
        'price',
        'sub_total',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => 'float',
        'sub_total' => 'float',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function options()
    {
        return $this->hasMany(CartItemOption::class);
    }
}
