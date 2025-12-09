<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'qty',
        'price',
        'subtotal',
        'is_returned',
        'is_refunded',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => 'float',
        'subtotal' => 'float',
        'is_returned' => 'boolean',
        'is_refunded' => 'boolean',
    ];

    /**
     * Get the order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    /**
     * Get return items for this order item
     */
    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class);
    }

    /**
     * Get order item options (for bundle products)
     */
    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }
}
