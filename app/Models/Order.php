<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'code',
        'shop_id',
        'user_id',
        'status',
        'ends_at',
        'notes',
    ];

    public function toSearchableArray()
    {
        return [
            'code' => $this->code,
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderUsers()
    {
        return $this->items->load('user')->pluck('user')->unique('id')->values();
    }

    public function orderItemsDetails()
    {
        $items = $this->items()->with('itemDetails')->get();
        $itemsDetails = $items->groupBy('item_details_id')->map(function ($group) {
            $itemDetailsInstance = $group->first()->itemDetails;

            return [
                'item_details' => $itemDetailsInstance,
                'quantity' => $group->sum('quantity'),
            ];
        })->values();

        return $itemsDetails;
    }
}
