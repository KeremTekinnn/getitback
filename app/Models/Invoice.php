<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ride;
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['ride_id', 'amount', 'status'];


    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
