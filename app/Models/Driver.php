<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'phone_number', 'profile_image', 'bus_id'];



    // One Driver has one Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
