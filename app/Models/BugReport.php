<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BugCategory;
use App\Enums\BugFrequency;
use App\Enums\BugPriority;
use App\Enums\BugStatus;

class BugReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'steps',
        'expected',
        'actual',
        'device',
        'frequency',
        'screenshots',
        'priority',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'category' => BugCategory::class,
        'frequency' => BugFrequency::class,
        'priority' => BugPriority::class,
        'status' => BugStatus::class,
        'screenshots' => 'array',
    ];
}