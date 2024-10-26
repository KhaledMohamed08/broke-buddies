<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopItem extends Model
{
    /** @use HasFactory<\Database\Factories\ShopItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_id',
        'name',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function detalis()
    {
        return $this->hasMany(ItemDetails::class);
    }
}
