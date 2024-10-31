<?php

use App\Models\ItemDetails;
use App\Models\User;
use App\Models\Order;
use App\Models\ShopItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(ShopItem::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(ItemDetails::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
