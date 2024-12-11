<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use App\Services\ShopCategoryService;
use App\Services\ShopService;

class ShopController extends Controller
{
    public function __construct(protected ShopService $shopService){}
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
        $shopCategories = (new ShopCategoryService)->index();

        return view('shops.create', compact(
            'shopCategories',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopRequest $request)
    {
        $data = $request->all();
        if (!isset($data['categories'])) {
            return redirect()->back()->with('fail', 'you do not have any category!');
        }
        
        $this->shopService->store($data);

        return redirect()->route('dashboard')->with('success', 'Shop Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
