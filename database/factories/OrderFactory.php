<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'code' => $this->generateUniqueCode(),
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => 1,
            'ends_at' => fake()->dateTime(),
            'notes' => fake()->realText(),
        ];
    }

    private function generateUniqueCode(): int
    {
        do {
            $code = rand(100000, 999999);
        } while (Order::where('code', $code)->exists());

        return $code;
    }
}
