<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Concern extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'details',
        'type',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('concern_image')
            ->singleFile();
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_concern');
    }
}
