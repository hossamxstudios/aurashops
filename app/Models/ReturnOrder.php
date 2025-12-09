<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'order_id',
        'address_id',
        'dropoff_location_id',
        'status',
        'total_refund_amount',
        'return_fee',
        'shipping_fee',
        'details',
        'is_refunded',
        'is_all_approved',
        'admin_notes',
        'client_notes',
    ];

    protected $casts = [
        'total_refund_amount' => 'float',
        'return_fee' => 'float',
        'shipping_fee' => 'float',
        'is_refunded' => 'boolean',
        'is_all_approved' => 'boolean',
    ];

    /**
     * Get the client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the original order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the address
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the dropoff location
     */
    public function dropoffLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'dropoff_location_id');
    }

    /**
     * Get all return items
     */
    public function items()
    {
        return $this->hasMany(ReturnItem::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Approve all items
     */
    public function approveAllItems()
    {
        $this->items()->update(['is_approved' => true]);
        $this->update(['is_all_approved' => true]);
    }

    /**
     * Mark all items as refunded
     */
    public function refundAllItems()
    {
        $this->items()->update(['is_refunded' => true]);
        $this->update(['is_refunded' => true]);
    }

    /**
     * Calculate total refund
     */
    public function calculateTotalRefund()
    {
        $itemsTotal = $this->items()->where('is_approved', true)->sum('refund_amount');
        $this->update([
            'total_refund_amount' => $itemsTotal - $this->return_fee - $this->shipping_fee
        ]);
    }
}
