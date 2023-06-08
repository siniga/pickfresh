<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignType;
use App\Http\Requests\StoreCampaignTypeRequest;
use App\Http\Requests\UpdateCampaignTypeRequest;
use Illuminate\Http\Request;

class CampaignTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $campaigns = CampaignType::get();
        return response($campaigns,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCampaignTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampaignType  $campaignType
     * @return \Illuminate\Http\Response
     */
    public function show(CampaignType $campaignType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampaignType  $campaignType
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignType $campaignType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCampaignTypeRequest  $request
     * @param  \App\Models\CampaignType  $campaignType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaignTypeRequest $request, CampaignType $campaignType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampaignType  $campaignType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaignType $campaignType)
    {
        //
    }
}
