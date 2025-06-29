<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FeedbackPriority;
use App\Enums\FeedbackStatus;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'feature',
        'usability',
        'performance',
        'experience',
        'suggestions',
        'priority',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'priority' => FeedbackPriority::class,
        'status' => FeedbackStatus::class,
    ];
}