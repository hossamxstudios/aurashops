<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'details',
        'discount_type',
        'discount_value',
        'min_order_value',
        'max_discount_value',
        'usage_limit',
        'usage_limit_client',
        'used_times',
        'is_active',
        'start_date',
        'end_date',
        'products',
        'categories',
        'brands',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_value' => 'integer',
        'max_discount_value' => 'integer',
        'usage_limit' => 'integer',
        'usage_limit_client' => 'integer',
        'used_times' => 'integer',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'products' => 'array',
        'categories' => 'array',
        'brands' => 'array',
    ];

    /**
     * Get all usages for this coupon
     */
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Check if coupon is valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now()->startOfDay();
        if ($this->start_date > $now || $this->end_date < $now) {
            return false;
        }

        if ($this->used_times >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if client can use this coupon
     */
    public function canBeUsedByClient($clientId)
    {
        $clientUsageCount = $this->usages()->where('client_id', $clientId)->count();
        return $clientUsageCount < $this->usage_limit_client;
    }

    /**
     * Get discount type badge color
     */
    public function getDiscountTypeBadgeAttribute()
    {
        return $this->discount_type === 'percentage' ? 'success' : 'info';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return $this->is_active ? 'success' : 'danger';
    }
}
