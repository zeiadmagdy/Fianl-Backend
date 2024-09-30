<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    use HasFactory, Notifiable;

    // Define the table name if it is not the default 'events'
    protected $table = 'events';

    // Allow mass assignment on these fields
    protected $fillable = [
        'name',
        'date',
        'description',
        'capacity',
        'location',
        'event_image',
        'category_id',// Foreign key to categories table
        'start_time',        // Start date (DATETIME)
        'end_time',          // End date (DATETIME)
    ];

    /**
     * Define a relationship where an event belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id'); // Use 'category_id' as the foreign key
    }

    /**
     * Define a relationship where an event belongs to a user (creator).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'users_id'); // Use 'users_id' as the foreign key
    }

    /**
     * Define a relationship where an event can have many attendees (users).
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')->withTimestamps();
    }
    

}
