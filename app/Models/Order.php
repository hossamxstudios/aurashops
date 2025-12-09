<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'pos_session_id',
        'client_id',
        'address_id',
        'shipping_rate_id',
        'pickup_location_id',
        'payment_method_id',
        'order_status_id',
        'source',
        'is_cod',
        'cod_amount',
        'cod_fee',
        'cod_type',
        'subtotal_amount',
        'discount_amount',
        'shipping_fee',
        'tax_rate',
        'tax_amount',
        'points_used',
        'points_rate',
        'points_to_cash',
        'total_amount',
        'coupon_code',
        'admin_notes',
        'client_notes',
        'ip_address',
        'user_agent',
        'device_info',
        'is_done',
        'is_paid',
        'has_returned_items',
        'is_canceled',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'tax_amount' => 'float',
        'discount_amount' => 'float',
        'shipping_fee' => 'float',
        'total' => 'float',
    ];

    /**
     * Get the client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all order items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get return orders
     */
    public function returnOrders()
    {
        return $this->hasMany(ReturnOrder::class);
    }

    /**
     * Get the POS session
     */
    public function posSession()
    {
        return $this->belongsTo(PosSession::class);
    }

    /**
     * Get order payments
     */
    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    /**
     * Get order status
     */
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * Get payment method
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get shipping address
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get shipping rate
     */
    public function shippingRate()
    {
        return $this->belongsTo(ShippingRate::class);
    }

    /**
     * Get pickup location
     */
    public function pickupLocation()
    {
        return $this->belongsTo(PickupLocation::class);
    }

    /**
     * Get shipment for this order
     */
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    /**
     * Get all shipments for this order
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    /**
     * Scope for POS orders only
     */
    public function scopePos($query)
    {
        return $query->where('source', 'POS');
    }

    /**
     * Scope for orders with active session
     */
    public function scopeWithSession($query)
    {
        return $query->whereNotNull('pos_session_id');
    }
}
