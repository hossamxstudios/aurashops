<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Value extends Model {
    use SoftDeletes;

    protected $fillable = [
        'attribute_id',
        'name',
        'is_active',
    ];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function variants(){
        return $this->belongsToMany(Variant::class, 'value_variant');
    }
}
