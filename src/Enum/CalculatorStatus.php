<?php

namespace App\Enum;

enum CalculatorStatus: string
{
    case In = 'in';
    case Out = 'out';
    case Removed = 'removed';

    public function getLabel(): string
    {
        return match ($this) {
            self::In => 'Disponible',
            self::Out => 'Indisponible',
            self::Removed => 'Retirée',
        };
    }
}
