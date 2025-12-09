<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'zone_id',
        'districtId',
        'districtName',
        'districtOtherName',
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
     * Get the zone that this district belongs to
     */
    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the city through zone
     */
    public function city(){
        return $this->hasOneThrough(City::class, Zone::class, 'id', 'id', 'zone_id', 'city_id');
    }

    /**
     * Get the addresses for this district
     */
    public function addresses(){
        return $this->hasMany(Address::class);
    }
}
