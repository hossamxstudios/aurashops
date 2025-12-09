<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PickupLocation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'warehouse_id',
        'city_id',
        'zone_id',
        'district_id',
        'type',
        'full_address',
        'working_hours',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'zip_code',
        'lat',
        'lng',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
    ];

    /**
     * Get the warehouse for this pickup location
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the city for this pickup location
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the zone for this pickup location
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the district for this pickup location
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
