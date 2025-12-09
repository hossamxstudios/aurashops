<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model {
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function values(){
        return $this->hasMany(Value::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'attribute_product');
    }
}
