<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ride;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['price_per_km'];


    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
