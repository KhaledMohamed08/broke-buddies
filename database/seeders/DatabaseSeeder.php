<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::create([
            'name' => 'Khaled',
            'phone' => '01093833112',
            'email' => 'khaledmohamed0796@gmail.com',
            'password' => Hash::make('1234567890')
        ]);

        $this->call([
            ShopSeeder::class,
            ShopItemSeeder::class,
        ]);
    }
}