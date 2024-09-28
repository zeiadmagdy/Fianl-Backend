<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'category_image']; // Update here

    /**
     * Define a relationship where a category has many events.
     */
    public function events()
    {
        return $this->hasMany(Event::class , 'category_id');
    }
}
