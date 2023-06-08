<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Http\Requests\StoreSkuRequest;
use App\Http\Requests\UpdateSkuRequest;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getBusinessSku($bid){
        $skus = Sku::join('product_skus','skus.id','product_skus.sku_id')
        ->join('products','products.id','product_skus.product_id')
        ->join('categories','categories.id','products.category_id')
        ->select('skus.id as serverId','skus.name')
        ->where('categories.business_id', $bid)
        ->distinct()
        ->get();

    return response(["skus" => $skus], 200);
    }

    public function getBusinessProductSku($bid, $productId){
        $skus = Sku::join('product_skus','skus.id','product_skus.sku_id')
        ->join('products','products.id','product_skus.product_id')
        ->join('categories','categories.id','products.category_id')
        ->select('skus.id as serverId','skus.name')
        ->where('categories.business_id', $bid)
        ->where('products.id', $productId)
        ->distinct()
        ->get();

    return response(["skus" => $skus], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSkuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSkuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function show(Sku $sku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function edit(Sku $sku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSkuRequest  $request
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSkuRequest $request, Sku $sku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sku $sku)
    {
        //
    }
}
