<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index()
    {
        $orders = (new OrderService)->index();
        $authOrders = $orders->where('user_id', Auth::user()->id);
        $shops = (new ShopService)->index();
        if (request()->has('search') && request()->search) {
            $orders = Order::search(request()->search)->get();
        } else {
            $orders = $orders;
        }
        
        return view('dashboard', compact([
            'orders',
            'authOrders',
            'shops',
        ]));
    }
}
