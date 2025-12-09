<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemOption extends Model
{
    protected $fillable = [
        'order_item_id',
        'bundle_item_id',
        'child_product_id',
        'child_variant_id',
        'type',
        'qty',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    /**
     * Get the order item
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the bundle item
     */
    public function bundleItem()
    {
        return $this->belongsTo(BundleItem::class);
    }

    /**
     * Get the child product
     */
    public function childProduct()
    {
        return $this->belongsTo(Product::class, 'child_product_id');
    }

    /**
     * Get the child variant
     */
    public function childVariant()
    {
        return $this->belongsTo(Variant::class, 'child_variant_id');
    }

    /**
     * Alias for child variant
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'child_variant_id');
    }
}
