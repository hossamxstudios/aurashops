<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleItemOption extends Model{

    protected $fillable = [
        'bundle_item_id',
        'variant_id',
    ];

    // Bundle item this option belongs to
    public function bundleItem(){
        return $this->belongsTo(BundleItem::class);
    }

    // Variant associated with this option
    public function variant(){
        return $this->belongsTo(Variant::class);
    }
}
