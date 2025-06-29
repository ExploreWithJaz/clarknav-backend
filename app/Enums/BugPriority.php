<?php

namespace App\Enums;

enum BugPriority: string
{
    case LOW = 'LOW';
    case MEDIUM = 'MEDIUM';
    case HIGH = 'HIGH';
    case CRITICAL = 'CRITICAL';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}