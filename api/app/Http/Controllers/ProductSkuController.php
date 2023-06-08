<?php

namespace App\Http\Controllers;

use App\Models\ProductSku;
use App\Http\Requests\StoreProductSkuRequest;
use App\Http\Requests\UpdateProductSkuRequest;

class ProductSkuController extends Controller
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
     * @param  \App\Http\Requests\StoreProductSkuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductSkuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductSku  $productSku
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSku $productSku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductSku  $productSku
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSku $productSku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductSkuRequest  $request
     * @param  \App\Models\ProductSku  $productSku
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductSkuRequest $request, ProductSku $productSku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSku  $productSku
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSku $productSku)
    {
        //
    }
}
