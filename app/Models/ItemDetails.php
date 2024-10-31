<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemDetails extends Model
{
    /** @use HasFactory<\Database\Factories\ItemDetailsFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_item_id',
        'size',
        'price',
        'description',
    ];

    public function item()
    {
        return $this->belongsTo(ShopItem::class, 'shop_item_id', 'id');
    }
}
