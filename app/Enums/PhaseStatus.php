<?php

namespace App\Enums;

enum PhaseStatus: string
{
    case UPCOMING = 'upcoming';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::UPCOMING => 'Akan Datang',
            self::ACTIVE => 'Aktif',
            self::COMPLETED => 'Selesai',
        };
    }
}
