<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shop_category_id',
        'name',
        'phone',
    ];

    public function items()
    {
        return $this->hasMany(ShopItem::class);
    }

    public function shopCategories()
    {
        return $this->hasMany(ItemCategory::class);
    }

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
