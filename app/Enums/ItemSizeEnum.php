<?php

namespace App\Enums;

enum ItemSizeEnum: int
{
    case SMALL = 1;
    case Medium = 2;
    case LARGE = 3;

    public function label(): string
    {
        return match($this)
        {
            self::SMALL => 'small',
            self::Medium => 'medium',
            self::LARGE => 'large',
        };
    }

    // public function badge(): string
    // {
    //     return match($this)
    //     {
    //         //
    //     };
    // }
}
