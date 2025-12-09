<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Playlist extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'details',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($playlist) {
            if (empty($playlist->slug)) {
                $playlist->slug = Str::slug($playlist->name);
            }
        });
    }

    /**
     * Get all videos for this playlist
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('playlist-thumbnails')
            ->singleFile();
    }
}
