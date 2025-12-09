<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'return_order_id',
        'order_item_id',
        'reason_id',
        'details',
        'refund_amount',
        'is_approved',
        'unit_price',
        'qty',
        'subtotal',
        'is_refunded',
        'admin_notes',
        'client_notes',
    ];

    protected $casts = [
        'refund_amount' => 'float',
        'unit_price' => 'float',
        'qty' => 'integer',
        'subtotal' => 'float',
        'is_approved' => 'boolean',
        'is_refunded' => 'boolean',
    ];

    /**
     * Get the return order
     */
    public function returnOrder()
    {
        return $this->belongsTo(ReturnOrder::class);
    }

    /**
     * Get the original order item
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the return reason
     */
    public function reason()
    {
        return $this->belongsTo(ReturnReason::class);
    }

    /**
     * Get approval status badge
     */
    public function getApprovalBadgeAttribute()
    {
        if (is_null($this->is_approved)) {
            return 'warning';
        }
        return $this->is_approved ? 'success' : 'danger';
    }

    /**
     * Get approval status text
     */
    public function getApprovalStatusAttribute()
    {
        if (is_null($this->is_approved)) {
            return 'Pending';
        }
        return $this->is_approved ? 'Approved' : 'Rejected';
    }
}
