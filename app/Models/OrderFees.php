<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderFees extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_id',
        'name',
        'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
