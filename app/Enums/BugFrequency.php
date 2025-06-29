<?php

namespace App\Enums;

enum BugFrequency: string
{
    case ALWAYS = 'Always';
    case SOMETIMES = 'Sometimes';
    case RARELY = 'Rarely';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}