<?php

namespace App\Enums;

enum FeedbackPriority: string
{
    case LOW = 'LOW';
    case MEDIUM = 'MEDIUM';
    case HIGH = 'HIGH';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}