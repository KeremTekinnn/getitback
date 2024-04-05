<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;
use App\Models\User;
use App\Models\Invoice;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = ['pickup', 'dropoff', 'date', 'distance', 'cost', 'user_id', 'payment_method', 'payment_id'];

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
