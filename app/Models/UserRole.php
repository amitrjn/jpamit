<?php

namespace App\Models;

enum UserRole: int
{
    case STUDENT = 1;
    case ORGANIZER = 2;

    public function label(): string
    {
        return match($this) {
            self::STUDENT => 'Student',
            self::ORGANIZER => 'Organizer',
        };
    }
} 