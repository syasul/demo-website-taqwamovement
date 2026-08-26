<?php

namespace App\Enums;

enum ContactMessageStatus: string
{
    case UNREAD = 'unread';
    case READ = 'read';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::UNREAD => 'Belum Dibaca',
            self::READ => 'Sudah Dibaca',
            self::ARCHIVED => 'Diarsipkan',
        };
    }
}
