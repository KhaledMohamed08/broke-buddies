<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderItemService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Services\OrderService;

class OrderItemController extends Controller
{
    public function __construct(protected OrderItemService $orderItemService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $order)
    {
        return view('orders.items.create', compact(
            'order',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemRequest $request)
    {
        $this->orderItemService->store($request->all());

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order, $x)
    {
        $user = User::find(Auth::id());
        $cartItems = $user->orderItemsForOrderId($order->id)->map(function ($item) {
            $itemDetails = (new OrderService)->show($item->item_details_id);

            return [
                'id' => $item->id,
                'name' => $item->name,
                'size' => $itemDetails->size ?? 'N/A',
                'price' => $itemDetails->price ?? 0,
                'quantity' => $item->quantity,
            ];
        });

        return view('orders.items.edit', compact('order', 'cartItems'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
