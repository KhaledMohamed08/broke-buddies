<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case IN_ACTIVE = 0;
    case ACTIVE = 1;

    public function label(): string
    {
        return match($this)
        {
            self::ACTIVE => 'active',
            self::IN_ACTIVE => 'in_active',
        };
    }

    public function badge(): string
    {
        return match($this)
        {
            self::ACTIVE => 'green',
            self::IN_ACTIVE => 'red',
        };
    }
}
