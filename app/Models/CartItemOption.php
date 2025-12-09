<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItemOption extends Model
{
    protected $fillable = [
        'cart_item_id',
        'bundle_item_id',
        'child_product_id',
        'child_variant_id',
        'type',
        'qty',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    // Relationships
    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function bundleItem()
    {
        return $this->belongsTo(BundleItem::class);
    }

    public function childProduct()
    {
        return $this->belongsTo(Product::class, 'child_product_id');
    }

    public function childVariant()
    {
        return $this->belongsTo(Variant::class, 'child_variant_id');
    }
}
