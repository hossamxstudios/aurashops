<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'shipper_id',
        'pickup_location_id',
        'address_id',
        'tracking_number',
        'status',
        'carrier_metadata',
        'picked_up_at',
        'out_for_delivery_at',
        'delivered_at',
        'failed_at',
        'returned_at',
        'cancelled_at',
        'estimated_delivery_at',
        'cod_amount',
        'cod_collected',
        'cod_collected_at',
        'cod_fee',
        'shipping_fee',
        'carrier_response',
        'webhook_data',
        'failed_reason',
        'client_notes',
        'carrier_notes',
    ];

    protected $casts = [
        'picked_up_at' => 'datetime',
        'out_for_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'failed_at' => 'datetime',
        'returned_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'estimated_delivery_at' => 'datetime',
        'cod_collected_at' => 'datetime',
        'cod_amount' => 'float',
        'cod_collected' => 'float',
        'cod_fee' => 'float',
        'shipping_fee' => 'float',
    ];

    /**
     * Get the order for this shipment
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the shipper for this shipment
     */
    public function shipper()
    {
        return $this->belongsTo(Shipper::class);
    }

    /**
     * Get the pickup location for this shipment
     */
    public function pickupLocation()
    {
        return $this->belongsTo(PickupLocation::class);
    }

    /**
     * Get the address for this shipment
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the tracking events for this shipment
     */
    public function trackingEvents()
    {
        return $this->hasMany(TrackingEvent::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'secondary',
            'picked_up' => 'info',
            'out_for_delivery' => 'primary',
            'delivered' => 'success',
            'failed' => 'danger',
            'returned' => 'warning',
            'cancelled' => 'dark',
            default => 'secondary',
        };
    }
}
