<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnReason extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all return items with this reason
     */
    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class, 'reason_id');
    }
}
