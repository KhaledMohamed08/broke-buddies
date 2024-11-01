<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Order());
    }

    public function store($data)
    {
        $data['code'] = $this->generateOrderCode();
        $data['user_id'] = Auth::id();

        $order = new Order();
        $order->code = $data['code'];
        $order->shop_id = $data['shop_id'];
        $order->user_id = $data['user_id'];
        $order->ends_at = $data['ends_at'];
        $order->notes = $data['notes'];
        $order->save();

        if (isset($data['fees'])) {
            foreach ($data['fees'] as $fee) {
                $fee['order_id'] = $order->id;
                $order->fees()->create($fee);
            }
        }

        return $order;
    }

    // public function update(Model $model, $data)
    // {

    // }

    private function generateOrderCode()
    {
        do {
            $code = rand(100000, 999999);
        } while (Order::where('code', $code)->exists());

        return $code;
    }
}
