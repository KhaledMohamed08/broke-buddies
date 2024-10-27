<?php

namespace App\Services;

use App\Models\OrderItem;

class OrderItemService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new OrderItem());
    }
}
