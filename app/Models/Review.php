<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'product_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the client who wrote the review
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the product being reviewed
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
