<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyLog extends Model {
    use SoftDeletes;

    protected $fillable = [
        'loyalty_account_id',
        'reference_id',
        'reference_type',
        'type',
        'points_before',
        'points',
        'points_after',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'points_before' => 'float',
        'points' => 'float',
        'points_after' => 'float',
        'expires_at' => 'date',
    ];

    public function loyaltyAccount(){
        return $this->belongsTo(LoyaltyAccount::class);
    }

    public function reference(){
        return $this->morphTo();
    }
}
