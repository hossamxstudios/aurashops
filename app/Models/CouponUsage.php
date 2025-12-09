<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponUsage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'coupon_id',
        'client_id',
        'order_id',
        'discount_value',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
    ];

    /**
     * Get the coupon
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
