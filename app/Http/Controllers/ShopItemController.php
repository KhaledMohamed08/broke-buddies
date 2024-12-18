<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopItemRequest;
use App\Http\Requests\UpdateShopItemRequest;
use App\Models\ShopItem;
use App\Services\ShopItemService;

class ShopItemController extends Controller
{
    public function __construct(protected ShopItemService $shopItemService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShopItem $shopItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopItem $shopItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopItemRequest $request, ShopItem $shopItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopItem $shopItem)
    {
        //
    }

    public function ajaxSearch($search)
    {
        return response()->json($this->shopItemService->search($search));
    }
}
