<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    // Define fillable attributes for mass assignment
    protected $fillable = ['name', 'latitude', 'longitude', 'description', 'arrived_time', 'bus_id'];

    // A point belongs to a bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
