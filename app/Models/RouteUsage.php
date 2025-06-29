<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'route_id',
        'route_name',
        'description',
        'color',
        'origin',
        'destination',
        'route_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}