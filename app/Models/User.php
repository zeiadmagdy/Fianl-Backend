<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Event;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'otp',
        'otp_expires_at',
        'location',      // Add location
        'gender',        // Add gender
        'bio',           // Add bio
        'birth_date',    // Add birth date
        'is_admin',      // Add admin role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->is_admin === 1;
    }

    /**
     * Define a relationship where a user can attend many events.
     */


    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id')->withTimestamps();
    }
    public function attendedEvents()
{
    return $this->belongsToMany(Event::class, 'event_user'); // Ensure 'Event' is the correct model
}

}
