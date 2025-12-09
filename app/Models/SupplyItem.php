<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplyItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supply_id',
        'product_id',
        'variant_id',
        'qty',
        'unit_price',
        'total',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'float',
        'total' => 'float',
    ];

    /**
     * Get the supply
     */
    public function supply()
    {
        return $this->belongsTo(Supply::class);
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
}
