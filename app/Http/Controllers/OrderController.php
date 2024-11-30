<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){}
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->orderService->store($request->all());

        return redirect()->back()->with('success', 'Order Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('orders.show', compact(
            'order',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $data['shop_id'] = $order->shop_id;
        $data['user_id'] = Auth::user()->id;
        $this->orderService->update($order, $data);

        return redirect()->back()->with('success', 'Order Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $this->orderService->destroy($order);

        return redirect()->back()->with('success', 'Order Deleted Successfuly.');
    }

    public function ajaxSearch($search)
    {
        return response()->json($this->orderService->search($search));
    }

    public function submitOrder(Order $order)
    {
        $this->orderService->submitOrder($order);

        return redirect()->back()->with('success', 'Order Submited Successfully');
    }
}
