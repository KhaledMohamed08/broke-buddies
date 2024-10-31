<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ShopService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function __construct(protected OrderService $orderService, protected ShopService $shopService){}

    public function index()
    {
        $orders = $this->orderService->index();
        $authOrders = $orders->where('user_id', Auth::user()->id);
        $joinedOrders = User::find(Auth::id())->joinedOrders();
        $shops = $this->shopService->index();
        if (request()->has('search') && request()->search) {
            $orders = $this->orderService->search(request()->search)->where('status', 1);
        } else {
            $orders = $orders->where('status', 1);
        }
        
        return view('dashboard', compact([
            'orders',
            'authOrders',
            'joinedOrders',
            'shops',
        ]));
    }
}
