<?php

namespace App\Services;

use App\Models\Shop;

class ShopService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Shop());
    }

    public function store(array $data)
    {
        $shop = $this->model->create($data);

        foreach ($data['categories'] as $categoryName => $categoryData) {
            $newCategory = $shop->shopCategories()->create(['name' => $categoryName]);

            foreach ($categoryData['items'] as $item) {
                $newItem = (new ShopItemService)->store([
                    'name' => $item['name'],
                    'shop_id' => $shop->id,
                    'item_category_id' => $newCategory->id,
                ]);

                foreach ($item['sizes'] as $size) {
                    $newItem->details()->create([
                        'shop_item_id' => $newItem->id,
                        'size' => in_array(strtolower($size['size']), ['s', 'm', 'l']) ? $size['size'] : null,
                        'price' => $size['price'],
                        'description' => $item['description'],
                    ]);
                }
            }
        }
    }
}
