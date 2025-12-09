<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'city_id',
        'zoneId',
        'zoneName',
        'zoneOtherName',
        'pickupAvailability',
        'dropOffAvailability',
        'is_active',
    ];

    protected $casts = [
        'pickupAvailability' => 'boolean',
        'dropOffAvailability' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the city that this zone belongs to
     */
    public function city(){
        return $this->belongsTo(City::class);
    }

    /**
     * Get the districts for this zone
     */
    public function districts(){
        return $this->hasMany(District::class);
    }

    /**
     * Get the addresses for this zone
     */
    public function addresses(){
        return $this->hasMany(Address::class);
    }
}
