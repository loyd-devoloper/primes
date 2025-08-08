<?php

namespace App\Enums;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MonitoringStatusEnum: string implements HasLabel,HasColor
{
    case EMPTY = '0';
    case INCOMPLETE = '1';
    case COMPLETE = '2';

    public function getLabel(): ?string
    {


        return match ($this) {
            self::EMPTY => 'EMPTY',
            self::INCOMPLETE => 'INCOMPLETE',
            self::COMPLETE => 'COMPLETE',

        };
    }
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::EMPTY => Color::Yellow,
            self::INCOMPLETE => Color::Blue,
            self::COMPLETE => Color::Green,

        };
    }

}
