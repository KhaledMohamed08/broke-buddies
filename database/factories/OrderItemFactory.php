<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ShopItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::inRandomOrder()->first();
        $shop_item = ShopItem::where('shop_id', $order->shop_id)->inRandomOrder()->first();

        return [
            'order_id' => $order->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'shop_item_id' => $shop_item->id,
        ];
    }
}
