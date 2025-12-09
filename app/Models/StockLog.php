<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stock_id',
        'type',
        'qty',
        'notes',
        'reference_id',
        'reference_type',
        'cost_per_unit',
        'total_cost',
    ];

    protected $casts = [
        'qty' => 'integer',
        'cost_per_unit' => 'float',
        'total_cost' => 'float',
    ];

    /**
     * Get the stock record
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Get type badge color
     */
    public function getTypeBadgeColorAttribute()
    {
        return match($this->type) {
            'add', 'purchase', 'return' => 'success',
            'remove', 'sale', 'damage', 'loss' => 'danger',
            'adjustment' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get type icon
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'add', 'purchase' => 'plus-circle',
            'remove', 'sale' => 'minus-circle',
            'return' => 'corner-up-left',
            'adjustment' => 'edit',
            'damage', 'loss' => 'alert-triangle',
            default => 'activity',
        };
    }
}
