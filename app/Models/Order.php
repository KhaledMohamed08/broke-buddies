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
            // Add other fields you want to be searchable
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
}
