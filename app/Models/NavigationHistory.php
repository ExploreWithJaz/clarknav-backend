<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'origin',
        'destination',
        'route_details',
        'navigation_confirmed',
    ];

    protected $casts = [
        'route_details' => 'array',
        'navigation_confirmed' => 'boolean',
    ];
}