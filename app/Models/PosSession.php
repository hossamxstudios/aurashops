<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosSession extends Model
{
    protected $fillable = [
        'user_id',
        'opened_at',
        'closed_at',
        'opening_cash',
        'expected_cash',
        'actual_cash',
        'difference',
        'orders_count',
        'total_sales',
        'notes',
        'status',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_cash' => 'decimal:2',
        'expected_cash' => 'decimal:2',
        'actual_cash' => 'decimal:2',
        'difference' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'orders_count' => 'integer',
    ];

    /**
     * Get the user (cashier) who owns the session
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all orders in this session
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if session is open
     */
    public function isOpen()
    {
        return $this->status === 'open';
    }

    /**
     * Check if session is closed
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Calculate expected cash
     */
    public function calculateExpectedCash()
    {
        $cashPayments = $this->orders()
            ->with('payments')
            ->get()
            ->pluck('payments')
            ->flatten()
            ->where('payment_method.slug', 'cash')
            ->sum('paid');
        
        return $this->opening_cash + $cashPayments;
    }

    /**
     * Update session statistics
     */
    public function updateStats()
    {
        $this->orders_count = $this->orders()->count();
        $this->total_sales = $this->orders()->sum('total_amount');
        $this->expected_cash = $this->calculateExpectedCash();
        $this->save();
    }
}
