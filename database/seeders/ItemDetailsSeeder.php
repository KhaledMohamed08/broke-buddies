<?php

namespace Database\Seeders;

use App\Models\ItemDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemDetails::factory()->count(100)->create();
    }
}
