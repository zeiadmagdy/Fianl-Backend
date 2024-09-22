<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    // Define the table name if it is not the default 'categories'
    protected $table = 'categories';

    // Allow mass assignment on these fields
    protected $fillable = ['name', 'description', 'capacity'];

    /**
     * Define a relationship where a category has many events.
     */
    public function events()
    {
        return $this->hasMany(Event::class); // Assuming you have an Event model
    }
}
