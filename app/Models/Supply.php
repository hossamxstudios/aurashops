<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'warehouse_id',
        'status',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_type',
        'discount_amount',
        'total',
        'is_delivered',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'tax_rate' => 'float',
        'tax_amount' => 'float',
        'discount_amount' => 'float',
        'total' => 'float',
        'is_delivered' => 'boolean',
    ];

    /**
     * Get the supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get all supply items
     */
    public function supplyItems()
    {
        return $this->hasMany(SupplyItem::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'completed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
