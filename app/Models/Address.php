<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {
    use SoftDeletes;
    
    protected $fillable = [
        'client_id',
        'phone',
        'full_address',
        'label',
        'apartment',
        'floor',
        'building',
        'street',
        'city_id',
        'zone_id',
        'district_id',
        'zip_code',
        'lat',
        'lng',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'lat' => 'float',
        'lng' => 'float',
    ];

    /**
     * Get the client that owns the address
     */
    public function client(){
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the city that this address belongs to
     */
    public function city(){
        return $this->belongsTo(City::class);
    }

    /**
     * Get the zone that this address belongs to
     */
    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the district that this address belongs to
     */
    public function district(){
        return $this->belongsTo(District::class);
    }

    /**
     * Get the full formatted address
     */
    public function getFormattedAddressAttribute(){
        return implode(', ', array_filter([
            $this->apartment ? "Apt {$this->apartment}" : null,
            $this->floor ? "Floor {$this->floor}" : null,
            $this->building,
            $this->street,
            $this->district ? $this->district->districtName : null,
            $this->zone ? $this->zone->zoneName : null,
            $this->city ? $this->city->cityName : null,
        ]));
    }
}
