<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderPayment extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'shipment_id',
        'bank_account_id',
        'transaction_id',
        'payment_status',
        'gateway_name',
        'gateway_response',
        'amount',
        'paid',
        'rest',
        'collection_fee',
        'net_amount',
        'remittance_status',
        'remittance_reference',
        'remittance_date',
        'is_done',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid' => 'decimal:2',
        'rest' => 'decimal:2',
        'collection_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'is_done' => 'boolean',
    ];

    /**
     * Get the order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the payment method
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
