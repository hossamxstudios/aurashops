<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cityId',
        'cityName',
        'cityOtherName',
        'cityCode',
    ];

    /**
     * Get the zones for this city
     */
    public function zones(){
        return $this->hasMany(Zone::class);
    }

    /**
     * Get the addresses for this city
     */
    public function addresses(){
        return $this->hasMany(Address::class);
    }

    /**
     * Get all districts through zones
     */
    public function districts(){
        return $this->hasManyThrough(District::class, Zone::class);
    }
}
