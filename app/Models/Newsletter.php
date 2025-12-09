<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'email',
    ];

    /**
     * Get the client associated with this subscription
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
