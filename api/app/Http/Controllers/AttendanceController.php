<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CheckIn;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{

    private $now;

    public function __construct()
    {
        $this->now = Carbon::now();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function attendanceStats(Request $request){
        return [
            "num_of_attendee" => $this->getAttendees($request),
            "total_ambassadors" =>$this->getTotalAmbassadors(),
            "attendance_trends" =>$this->getAttendanceTrends($request),
            "recent_attendance" => $this->getRecentAttendance($request),
            "regional_attendance" => $this->getRegionalAttendance($request),
            "regions"=> $this->getRegions($request)
        ];
    }

    public function getAttendees($request){
        $groupBy = [];
        $whereClouse ='';
        $whereAggregate = '';
        $signs = '=';
        
        if($request->filter == 1){

            $groupBy = ['teams.id','teams.name'];
            $whereClouse = 'teams.id';
            $signs = '!=';
            $whereAggregate =  '0';
    
        }

        
        if($request->filter == 2){

            $whereClouse = 'teams.id';
            $signs = '=';
            $whereAggregate =  $request->team_id;
            $header = 'regions';
           

        }

        if($request->filter == 3){

            $whereClouse = 'branches.id';
            $signs = '=';
            $whereAggregate =  $request->branch_id;

        }

        $start = $this->now->copy()->startOfDay()->addHours(0)->addMinutes(0)->format('Y-m-d H:i:s');
        $end  = $this->now->copy()->startOfDay()->addHours(23)->addMinutes(59)->format('Y-m-d H:i:s');

        $attendance = Attendance::select('user_id')->distinct()
            ->join('users','users.id','attendances.user_id')
            ->join('branches','branches.id','users.branch_id')
            ->join('teams', 'teams.id','branches.team_id')
            ->whereBetween('attendances.device_time',[$start, $end])
            ->where($whereClouse,$signs, $whereAggregate)
            ->get();
        return $attendance->count();
    }

    public function getTotalAmbassadors(){
        $ambassadors = DB::table('users')
            ->join('user_roles','users.id','user_roles.user_id')
            ->where('user_roles.role_id', 5)
            ->get();

        return $ambassadors->count();
    }

    public function getRecentAttendance($request){
        //today attendance
        $groupBy = [];
        $whereClouse ='';
        $whereAggregate = '';
        $signs = '=';
        
        if($request->filter == 1){

            $groupBy = ['teams.id','teams.name'];
            $whereClouse = 'teams.id';
            $signs = '!=';
            $whereAggregate =  '0';
    
        }

        
        if($request->filter == 2){

            $whereClouse = 'teams.id';
            $signs = '=';
            $whereAggregate =  $request->team_id;
            $header = 'regions';
           

        }

        if($request->filter == 3){

            $whereClouse = 'branches.id';
            $signs = '=';
            $whereAggregate =  $request->branch_id;

        }

        $start = $this->now->copy()->startOfDay()->addHours(0)->addMinutes(0)->format('Y-m-d H:i:s');
        $end  = $this->now->copy()->startOfDay()->addHours(23)->addMinutes(59)->format('Y-m-d H:i:s');

        $recent = Attendance::join('users','users.id','attendances.user_id')
            ->join('check_ins', 'attendances.id','check_ins.attendance_id')
            ->join('branches','branches.id','users.branch_id')
            ->join('teams', 'teams.id','branches.team_id')
            ->selectRaw('users.name, attendances.check_in_date, check_ins.check_in_time, check_ins.check_out_time, check_ins.check_in_location, check_ins.check_out_location, count(attendances.check_in_date) as total_attendance')
            ->groupBy('users.name','check_ins.check_in_time','attendances.check_in_date', 'check_ins.check_out_time', 'check_ins.check_in_location', 'check_ins.check_out_location')
            ->whereBetween('attendances.device_time',[$start, $end])
            ->orderBy('check_ins.check_in_time','desc')
            ->where($whereClouse,$signs, $whereAggregate)
            ->get();

        return $recent;
    }

    public function getRegions($request){
        $response = [];
        $regions = [];
        $header = "";
        $select = "";
        $groupBy = [];
        $whereClouse ='';
        $whereAggregate = '';
        $signs = '=';

        if($request->filter == 1){

            $groupBy = ['teams.id','teams.name'];
            $select = 'teams.id, teams.name, count(attendances.id) attendance_by_region';
            $header = "overview";
            $whereClouse = 'teams.id';
            $signs = '!=';
            $whereAggregate =  '0';
    
        }

        if($request->filter == 2){

            $groupBy = ['branches.id','branches.name'];
            $select = 'branches.id, branches.name, count(attendances.id) attendance_by_region';

            $whereClouse = 'teams.id';
            $signs = '=';
            $whereAggregate =  $request->team_id;
            $header = 'regions';
           

        }
        
        if($request->filter == 3){

            $groupBy = ['users.id','users.name'];
            $select = 'users.id, users.name,  count(attendances.id) attendance_by_region';

            $whereClouse = 'branches.id';
            $signs = '=';
            $whereAggregate =  $request->branch_id;

        }

        $regions = DB::table('teams')
            ->leftJoin('branches','teams.id','branches.team_id')
            ->leftJoin('users','branches.id','users.branch_id')
            ->leftJoin('attendances','users.id','attendances.user_id')
            ->selectRaw($select)
            ->groupBy($groupBy)
            ->where($whereClouse,$signs, $whereAggregate)
            ->distinct()
            ->get();

        return [$regions, $header];
    }

    public function getRegionalAttendance($request){
        $response = [];
        $regions = [];
        $header = "";
        $select = "";
        $groupBy = [];
        $whereClouse ='';
        $whereAggregate = '';
        $signs = '=';
        
        if($request->filter == 1){

            $groupBy = ['teams.id','teams.name'];
            $select = 'teams.id, teams.name, count(attendances.id) attendance_by_region';
            $header = "Region";
            $whereClouse = 'teams.id';
            $signs = '!=';
            $whereAggregate =  '0';
    
        }

        if($request->filter == 2){

            $groupBy = ['branches.id','branches.name'];
            $select = 'branches.id, branches.name, count(attendances.id) attendance_by_region';
            $header = 'branches';
            $whereClouse = 'teams.id';
            $signs = '=';
            $whereAggregate =  $request->team_id;

        }

        if($request->filter == 3){

            $groupBy = ['users.id','users.name'];
            $select = 'users.id, users.name,  count(attendances.id) attendance_by_region';
            $header = 'Individuals';

            $whereClouse = 'branches.id';
            $signs = '=';
            $whereAggregate =  $request->branch_id;

        }

        $regions = Attendance::rightJoin('users','users.id','attendances.user_id')
            ->rightJoin('branches','branches.id','users.branch_id')
            ->rightJoin('teams','teams.id','branches.team_id')
            ->selectRaw($select)
            ->groupBy($groupBy)
            ->where($whereClouse,$signs, $whereAggregate)
            ->whereBetween('attendances.check_in_date',[$request->startDate, $request->endDate])
            ->limit(10)
            ->get();

        foreach ($regions as $value) {
            array_push($response, [$value->name, $value->attendance_by_region]);
        }
            
        array_unshift($response,[$header,"stats"]);

        if(count($regions) > 0){
            return $response;
        }else{
            return $regions;
        }
    }

    //TODO: create all these functions in traits
    //so that they can be shared btn controllers
    public function getAttendanceTrends($request){

        if($request->time_flag == 1){
            return [ 'attendance' =>[
                        ["Today", "Attendance"],
                        $this->getTodayAttendance($request, 0, 8,0,59, "12am - 09am"),
                        $this->getTodayAttendance($request, 9,11, 0, 59, "9am - 12pm"),
                        $this->getTodayAttendance($request, 12, 14, 0, 59, "12pm - 3pm"),
                        $this->getTodayAttendance($request, 15, 23, 0, 59, "3pm - 11pm"),
                    ]
                ];

            return;
        }

        if($request->time_flag == 2){
            return ['attendance' =>[
                    ["Last 7 days", "Attendance"],
                    $this->get7daysAttendance($request, 0, 0, 'Mon'),
                    $this->get7daysAttendance($request, 1, 1, 'Tue'),
                    $this->get7daysAttendance($request, 2, 2, 'Wed'),
                    $this->get7daysAttendance($request, 3, 3, 'Thu'),
                    $this->get7daysAttendance($request, 4, 4, 'Fri'),
                    $this->get7daysAttendance($request, 5, 5, 'Sat'),
                    $this->get7daysAttendance($request, 6, 6, 'Sun'),
                ]
            ];
        }

        
        if($request->time_flag == 3){
            return ['attendance' =>[
                    ["Today", "Attendance"],
                    $this->get30daysAttendance($request, 0, 1, "Week 1"),
                    $this->get30daysAttendance($request, 1, 2, "Week 2"),
                    $this->get30daysAttendance($request, 2, 3, "Week 3"),
                    $this->get30daysAttendance($request, 3, 4, "Week 4")
                ]
            ];
        }

        
        if($request->time_flag == 4){
            return ['attendance' =>[
                    ["1 Year", "Attendance"],
                    $this->get1yearAttendance($request, 0,0),
                    $this->get1yearAttendance($request, 1,1),
                    $this->get1yearAttendance($request, 2,2),
                    $this->get1yearAttendance($request, 3,3),
                    $this->get1yearAttendance($request, 4,4),
                    $this->get1yearAttendance($request, 5,5),
                    $this->get1yearAttendance($request, 6,6),
                    $this->get1yearAttendance($request, 7,7),
                    $this->get1yearAttendance($request, 8,8),
                    $this->get1yearAttendance($request, 9,9),
                    $this->get1yearAttendance($request, 10,10),
                    $this->get1yearAttendance($request, 11,11)
                ]
            ];
        }
        
    }

    public function filterAttendance($request, $start, $end){
        if($request->filter == 1){

            $attendanceData = $this->getAttandanceData($start, $end);
            $attendance =  $attendanceData->get();

        }

        if($request->filter == 2){

            $attendanceData = $this->getAttandanceData($start, $end);
            $attendanceData->where('teams.id', $request->team_id);
            $attendance =  $attendanceData->get();

        }

        if($request->filter == 3){

            $attendanceData = $this->getAttandanceData($start, $end);
            $attendanceData->where('branches.id', $request->branch_id);
            $attendance =    $attendanceData->get();

        } 
        
        return $attendance;
    }

    public function getTodayAttendance($request, $startHour, $endHour, $startMin, $endMin, $timeline){
        $start = $this->now->copy()->startOfDay()->addHours($startHour)->addMinutes($startMin)->format('Y-m-d H:i:s');
        $end  = $this->now->copy()->startOfDay()->addHours($endHour)->addMinutes($endMin)->format('Y-m-d H:i:s');
       
        $attendance = $this->filterAttendance($request, $start, $end);
       
        $response = [
            $timeline,
            $attendance[0]->num_of_attendee, 
        ];

        return $response;
    }

    public function get7daysAttendance($request, $startDay,$endDay, $timeline){
        $start = $this->now->copy()->startOfWeek()->startOfDay()->addDay($startDay);
        $end =  $this->now->copy()->startOfWeek()->endOfDay()->addDay($startDay);
        // return [$start, $end];
        $attendance = $this->filterAttendance($request, $start, $end);
            
        $response = [
            $timeline,
            $attendance[0]->num_of_attendee, 
        ];

        return $response;
    }

    public function get30daysAttendance($request, $startWeek, $endWeek, $timeline){
        $start = $this->now->copy()->startOfMonth()->addWeek($startWeek);
        $end = $this->now->copy()->startOfMonth()->endOfWeek()->addWeek($endWeek);

        $attendance = $this->filterAttendance($request, $start, $end);
            
        $response = [
            $timeline,
            $attendance[0]->num_of_attendee, 
        ];

        return $response;
    }

    
    public function get1yearAttendance($request, $startMonth, $endMonth){
        $start = $this->now->copy()->startOfYear()->addMonthsNoOverflow($startMonth);
        $end = $this->now->copy()->startOfYear()->endOfMonth()->addMonthsNoOverflow($endMonth);

        $attendance = $this->filterAttendance($request, $start, $end);
            
        $response = [
            $end->format('M'),
            $attendance[0]->num_of_attendee, 
        ];

        return $response;
    }


    public function getAttandanceData($start, $end){
    
        //TODO: use device time as oposed to created at 
       $attendance  = DB::table('users')
           ->join('branches','branches.id','users.branch_id')
           ->join('teams','teams.id','branches.team_id')
           ->join('attendances','users.id','attendances.user_id')
           ->selectRaw('count(users.id) as num_of_attendee')
           ->whereBetween('attendances.device_time',[$start, $end]);

       return $attendance;

   }


 
    public function store(Request $request)
    {
        // if(Attendance::where('check_in_date', $request->check_in_date)->where('user_id',$request->user_id)->exists()){
        //     $attendance =  Attendance::where('check_in_date', $request->check_in_date)->where('user_id',$request->user_id)->first();
        //     $response = $this->checkUserIn($request, $attendance);

        //     $updated = DB::table('attendances')
        //         ->where('check_in_date', $request->check_in_date)
        //         ->where('user_id',$request->user_id)
        //         ->update(
        //             [
        //                 'check_out_date' => $request->check_out_date,
                    
        //             ]
        //         );

        //     return response($response, 201);
        //  }
         
        //
        $attendance = new Attendance;
        $attendance->check_in_date = $request->check_in_date;
        $attendance->check_out_date = $request->check_out_date;
      //  $attendance->device_time = $request->device_time;
        $attendance->user_id = $request->user_id;

        if($attendance->save()){

            $response =  $this->checkUserIn($request, $attendance);

            return response($response, 201);
        }
    }

    //TODO: use traits to share this function
    public function checkUserIn(Request $request, $attendance){

        $response = [];
                                                                
       // if check in time and attendance id is the same update /checkout else create checkin
        if(Checkin::where('check_in_time', $request->check_in_time)->where('attendance_id',$attendance->id)->exists()){
          
            $checkin = DB::table('check_ins')
                ->where('check_in_time', $request->check_in_time)
                ->where('attendance_id',$attendance->id)
                ->update(
                    [
                        'check_out_time' => $request->check_out_time,
                        'check_out_location' => $request->check_out_location,
                        'check_out_lat' =>$request->check_out_lat,
                        'check_out_lng' =>$request->check_out_lng
                    
                    ]
                );
        
                $response = [
                    "attendance" => $attendance
                ];

                return $response;
          
         }

        $checkin = new CheckIn;
        $checkin->check_in_time = $request->check_in_time;
        $checkin->check_in_location = $request->check_in_location;
        $checkin->check_in_lat = $request->check_in_lat;
        $checkin->check_in_lng = $request->check_in_lng;
        $checkin->check_out_time = $request->check_out_time;
        $checkin->check_out_location = $request->check_out_location;
        $checkin->check_out_lat = $request->check_out_lat;
        $checkin->check_out_lng = $request->check_out_lng;
        $checkin->attendance_id = $attendance->id;

        if($checkin->save()){
            $response = [
                "attendance" => $attendance
            ];
          
            return $response;
        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
