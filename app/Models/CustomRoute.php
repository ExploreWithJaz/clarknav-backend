<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'origin', 'destination', 'route_name', 'fare', 'student_fare', 'duration', 'departure_time', 'arrival_time', 'departure_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}