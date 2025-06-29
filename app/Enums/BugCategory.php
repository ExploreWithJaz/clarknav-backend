<?php

namespace App\Enums;

enum BugCategory: string
{
    case UI = 'UI';
    case PERFORMANCE = 'Performance';
    case INCORRECT_MARKER = 'Incorrect-Marker';
    case ROUTE_PATH = 'Route-Path';
    case OTHER = 'Other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}