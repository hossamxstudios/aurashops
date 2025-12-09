<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SkinTone extends Model implements HasMedia {

    use SoftDeletes,InteractsWithMedia;
    protected $fillable = [
        'name'
    ];

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void{
        $this->addMediaCollection('skin_tone_image')->singleFile()->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
    }

    /**
     * Get clients with this skin tone
     */
    public function clients(){
        return $this->hasMany(Client::class);
    }
}
