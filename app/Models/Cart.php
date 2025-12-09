<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Cart extends Model
{
    protected $fillable = [
        'client_id',
        'session_id',
        'pos_session_id',
        'subtotal',
        'total',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function posSession()
    {
        return $this->belongsTo(PosSession::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Recalculate cart totals based on items
     */
    public function recalculateTotals()
    {
        $items = $this->items()->get();

        $subtotal = 0;
        $total = 0;

        foreach ($items as $item) {
            $itemSubtotal = $item->price * $item->qty;
            $subtotal += $itemSubtotal;

            // Update item subtotal
            $item->sub_total = $itemSubtotal;
            $item->save();
        }

        $total = $subtotal; // Add tax, discounts, shipping here if needed

        // Try to update cart totals if columns exist

        return [
            'subtotal' => $subtotal,
            'total' => $total,
            'count' => $items->count(),
        ];
    }
}
