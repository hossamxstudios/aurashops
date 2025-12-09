<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingRate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shipper_id',
        'city_id',
        'rate',
        'cod_fee',
        'cod_type',
        'is_free_shipping',
        'free_shipping_threshold',
    ];

    protected $casts = [
        'is_free_shipping' => 'boolean',
        'rate' => 'decimal:2',
        'cod_fee' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
    ];

    /**
     * Get the shipper for this rate
     */
    public function shipper()
    {
        return $this->belongsTo(Shipper::class);
    }

    /**
     * Get the city for this rate
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
