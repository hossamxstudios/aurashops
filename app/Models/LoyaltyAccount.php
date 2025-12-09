<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyAccount extends Model {

    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'all_points',
        'points',
        'used_points',
    ];

    protected $casts = [
        'all_points' => 'float',
        'points' => 'float',
        'used_points' => 'float',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function logs(){
        return $this->hasMany(LoyaltyLog::class);
    }
}
