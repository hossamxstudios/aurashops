<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipper extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'carrier_name',
        'api_endpoint',
        'api_key',
        'api_secret',
        'api_password',
        'delivery_time',
        'delivery_days',
        'cod_fee',
        'cod_fee_type',
        'cod_min',
        'cod_max',
        'is_support_cod',
        'is_active',
    ];

    protected $casts = [
        'is_support_cod' => 'boolean',
        'is_active' => 'boolean',
        'cod_fee' => 'float',
        'cod_min' => 'float',
        'cod_max' => 'float',
    ];

    protected $hidden = [
        'api_key',
        'api_secret',
        'api_password',
    ];

    /**
     * Get shipping rates for this shipper
     */
    public function shippingRates()
    {
        return $this->hasMany(ShippingRate::class);
    }
}
