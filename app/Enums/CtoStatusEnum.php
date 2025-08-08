<?php
namespace App\Enums;



enum CtoStatusEnum: string
{
    case ACTIVE = 'ACTIVE';
    case PENDING = 'PENDING';
    case DISAPPROVED = 'DISAPPROVED';
    case EXPIRED = 'EXPIRED';

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::ACTIVE => 'success',
            self::DISAPPROVED => 'danger',
            self::EXPIRED => 'danger',
        };
    }
}
