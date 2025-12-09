<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackingEvent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shipment_id',
        'status',
        'carrier_status_code',
        'carrier_status_label',
        'location',
        'location_details',
        'details',
        'raw_data',
    ];

    protected $casts = [
        'raw_data' => 'array',
    ];

    /**
     * Get the shipment for this tracking event
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
