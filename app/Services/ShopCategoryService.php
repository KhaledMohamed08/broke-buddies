<?php

namespace App\Services;

use App\Models\ShopCategory;

class ShopCategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new ShopCategory());
    }
}
