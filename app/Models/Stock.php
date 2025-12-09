<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'variant_id',
        'qty',
        'reorder_qty',
        'is_active',
    ];

    protected $casts = [
        'qty' => 'integer',
        'reorder_qty' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the warehouse for this stock
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the product for this stock
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant for this stock
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    /**
     * Get all stock logs
     */
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class)->orderBy('created_at', 'desc');
    }

    /**
     * Check if stock is low (below reorder quantity)
     */
    public function isLowStock()
    {
        return $this->qty <= $this->reorder_qty;
    }

    /**
     * Get stock status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        if ($this->qty <= 0) {
            return 'danger';
        } elseif ($this->isLowStock()) {
            return 'warning';
        } else {
            return 'success';
        }
    }
}
