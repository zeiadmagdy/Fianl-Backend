<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

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
        'categories_id', // Foreign key to categories table
        'users_id',     // Foreign key to users table
    ];

    /**
     * Define a relationship where an event belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'categories_id'); // Use 'categories_id' as the foreign key
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
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user'); // Assuming 'event_user' is the pivot table
    }
}
