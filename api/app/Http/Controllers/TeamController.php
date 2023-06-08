<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTeamsByCampaignId($cid){
        $teams = Team::join('regions','regions.id','teams.region_id')
        ->join('campaigns','campaigns.id','teams.campaign_id')
        ->select('teams.id','teams.name','teams.created_at','regions.name as region','campaigns.name as campaign')
        ->where('campaign_id', $cid)
        ->orderBy('teams.id', 'desc')
        ->get();

        $teams->map(function($val, $key){
            $val->time_ago = Carbon::parse($val->created_at)->diffForhumans();
    
        });
        return $teams;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        $team = new Team;
        $team->name = $request->name;
        $team->region_id = $request->region_id;
        $team->campaign_id = $request->campaign_id;

        if($team->save()){
            return response($team, 200);
        }
    }
    public function destroy($id)
    {
        //
        $team = Team::findOrFail($id);
        $teamUsers = $team->users;

        if(count($teamUsers) > 0)
        $team->users()->detach($teamUsers[0]->id);

        if($team->delete()){
 
            return response($team, 200);
       }
    }
}
