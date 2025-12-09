<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'contact_person',
        'contact_email',
        'contact_phone',
        'address',
        'website',
        'payment_terms',
        'currency',
        'notes',
        'is_active',
        'last_supply_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_supply_at' => 'datetime',
    ];

    /**
     * Get all supplies from this supplier
     */
    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
}
