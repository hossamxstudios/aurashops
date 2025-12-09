<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'playlist_id',
        'title',
        'slug',
        'details',
        'link',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($video) {
            if (empty($video->slug)) {
                $video->slug = Str::slug($video->title);
            }
        });
    }

    /**
     * Get the playlist
     */
    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
