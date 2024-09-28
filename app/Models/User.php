<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
<<<<<<< HEAD
        'name',
        'email',
        'password',
        'profile_image', 
        'otp',
        'otp_expires_at',
=======
        'name',           // Add name
        'email',         // Add email
        'password',       // Add password
        'profile_image',  // Add profile_image
        'location',      // Add location
    'gender',        // Add gender
    'bio',           // Add bio
    'birth_date',    // Add birth date
    'is_admin',      // Add is_admin
>>>>>>> c34e087f877d3c556e2e19605f769f3d4a412088
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin() {
        return $this->is_admin === 1;
    }

    /**
     * Define a relationship where a user can attend many events.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'events_users'); // Use 'users_events' as the pivot table
    }
}
