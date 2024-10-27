<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index()
    {
        $orders = (new OrderService)->index();
        $authOrders = $orders->where('user_id', Auth::user()->id);
        $shops = (new ShopService)->index();
        
        return view('dashboard', compact([
            'orders',
            'authOrders',
            'shops',
        ]));
    }
}
