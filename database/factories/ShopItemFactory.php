<?php

namespace Database\Factories;

use App\Models\ItemCategory;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShopItem>
 */
class ShopItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shop = Shop::inRandomOrder()->first();
        $itemCategoryId = null;

        while (is_null($itemCategoryId)) {
            $itemCategory = ItemCategory::where('shop_id', $shop->id)->inRandomOrder()->first();
            
            if ($itemCategory) {
                $itemCategoryId = $itemCategory->id;
            }
        }

        return [
            'shop_id' => $shop->id,
            'name' => fake()->name(),
            'item_category_id' => $itemCategoryId,
        ];
    }
}
