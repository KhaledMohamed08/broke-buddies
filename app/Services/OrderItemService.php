<?php

namespace App\Services;

use Log;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\ItemDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderItemService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new OrderItem());
    }

    public function store($data)
    {
        $order_id = $data['order_id'];
        $user_id = Auth::user()->id;

        try {
            DB::transaction(function () use ($data, $order_id, $user_id) {
                foreach ($data['items'] as $item) {
                    $item['order_id'] = $order_id;
                    $item['user_id'] = $user_id;
                    $item['item_details_id'] = ItemDetails::where('price', $item['price'])->pluck('id')->first();

                    OrderItem::create($item);
                }
            });

            return response()->json(['message' => 'Items created successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating order items: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create items. Please try again later.'], 500);
        }
    }

    public function update(Model $model, array $data)
    {
        $order_id = $data['order_id'];
        $user_id = Auth::user()->id;

        try {
            DB::transaction(function () use ($data, $order_id, $user_id) {
                $existingItems = OrderItem::where('order_id', $order_id)->where('user_id', $user_id)->pluck('item_details_id')->toArray();
                $newItemDetailsIds = [];

                foreach ($data['items'] as $item) {
                    $item_details_id = ItemDetails::where('price', $item['price'])->pluck('id')->first();
                    $item['item_details_id'] = $item_details_id;
                    $item['order_id'] = $order_id;
                    $item['user_id'] = $user_id;
                    $newItemDetailsIds[] = $item_details_id;

                    OrderItem::updateOrCreate(
                        [
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                            'item_details_id' => $item_details_id
                        ],
                        $item
                    );
                }
                $itemsToDelete = array_diff($existingItems, $newItemDetailsIds);
                
                if (!empty($itemsToDelete)) {
                    OrderItem::where('order_id', $order_id)
                        ->where('user_id', $user_id)
                        ->whereIn('item_details_id', $itemsToDelete)
                        ->delete();
                }
            });

            return response()->json(['message' => 'Items created successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating order items: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create items. Please try again later.'], 500);
        }
    }

    public function orderCartItems($order)
    {
        $user = User::find(Auth::id());
        $cartItems = $user->orderItemsForOrderId($order->id)->map(function ($item) {
            $itemDetails = (new BaseService(new ItemDetails()))->show($item->item_details_id);

            return [
                'id' => $item->id,
                'shop_item_id' => $item->shop_item_id,
                'item_details_id' => $itemDetails->id,
                'name' => $item->item->name,
                'size' => $itemDetails->size ?? 'One Size',
                'price' => $itemDetails->price ?? 0,
                'quantity' => $item->quantity,
            ];
        });

        return $cartItems;
    }
}
