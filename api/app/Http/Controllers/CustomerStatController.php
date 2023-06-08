<?php

namespace App\Http\Controllers;

use App\Models\CustomerStat;
use App\Http\Requests\StoreCustomerStatRequest;
use App\Http\Requests\UpdateCustomerStatRequest;

class CustomerStatController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomerStatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerStatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerStat  $customerStat
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerStat $customerStat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerStat  $customerStat
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerStat $customerStat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerStatRequest  $request
     * @param  \App\Models\CustomerStat  $customerStat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerStatRequest $request, CustomerStat $customerStat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerStat  $customerStat
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerStat $customerStat)
    {
        //
    }
}
