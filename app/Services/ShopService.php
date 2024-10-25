<?php

namespace App\Services;

use App\Models\Shop;

class ShopService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Shop());
    }
}
