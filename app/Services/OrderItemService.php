<?php

namespace App\Services;

use Log;
use App\Models\OrderItem;
use App\Models\ItemDetails;
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
}
