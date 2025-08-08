<?php
namespace App\Enums;



enum LeaveStatusEnum: string
{
    case APPROVED = 'APPROVED';
    case PENDING = 'PENDING';
    case DISAPPROVED = 'DISAPPROVED';
    case CANCELLED = 'CANCELLED';

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::DISAPPROVED => 'danger',
            self::CANCELLED => 'danger',
        };
    }
}
