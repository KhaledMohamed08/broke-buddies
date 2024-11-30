<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case IN_ACTIVE = 0;
    case ACTIVE = 1;
    case SUBMITED = 2;

    public function label(): string
    {
        return match($this)
        {
            self::ACTIVE => 'Active',
            self::IN_ACTIVE => 'In Active',
            self::SUBMITED => 'Submited',
        };
    }

    public function badge(): string
    {
        return match($this)
        {
            self::ACTIVE => 'green',
            self::IN_ACTIVE => 'red',
            self::SUBMITED => 'blue',
        };
    }
}
