<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\CustomVerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements HasMedia, JWTSubject, MustVerifyEmail {

    use HasApiTokens, HasFactory, HasRoles, InteractsWithMedia,Notifiable, SoftDeletes;

    protected $guard = 'client';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'gender',
        'birthdate',
        'skin_tone_id',
        'skin_type_id',
        'referred_by_id',
        'code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
    ];

    public function referrer(){
        return $this->belongsTo(Client::class, 'referred_by_id');
    }

    public function skinTone(){
        return $this->belongsTo(SkinTone::class);
    }

    public function skinType(){
        return $this->belongsTo(SkinType::class);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function concerns(){
        return $this->belongsToMany(Concern::class, 'client_concern');
    }

    public function loyaltyAccount(){
        return $this->hasOne(LoyaltyAccount::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute() {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new CustomVerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

}
