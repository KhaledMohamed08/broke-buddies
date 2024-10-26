<?php

namespace Database\Factories;

use App\Models\ShopItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemDetails>
 */
class ItemDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sizes = [null, 's', 'm', 'l'];
        $randomKey = array_rand($sizes);
        $randomSize = $sizes[$randomKey];

        return [
            'shop_item_id' => ShopItem::inRandomOrder()->first()->id,
            'size' => $randomSize,
            'price' => fake()->randomFloat(2, 1, 500),
            'description' => fake()->realText(),
        ];
    }
}
