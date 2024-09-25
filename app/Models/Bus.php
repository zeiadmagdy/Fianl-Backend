<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    // Define fillable attributes for mass assignment
    protected $fillable = ['name', 'bus_number', 'capacity', 'bus_line'];

    // One Bus has many Points
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    // One Bus has one Driver
    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
}
