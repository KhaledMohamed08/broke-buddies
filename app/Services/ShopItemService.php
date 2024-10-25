<?php

namespace App\Services;

use App\Models\ShopItem;

class ShopItemService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new ShopItem());
    }
}
