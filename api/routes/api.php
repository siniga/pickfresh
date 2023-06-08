<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//resert cache routes
// clear route cache
Route::get('/clear-route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has clear successfully !';
});

//clear config cache
Route::get('/clear-config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has clear successfully !';
});

// clear application cache
Route::get('/clear-app-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has clear successfully!';
});

// clear view cache
Route::get('/clear-view-cache', function () {
    Artisan::call('view:clear');
    return 'View cache has clear successfully!';
});

// header('Access-Control-Allow-Origin', '*');
// header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers', 'Content-Type, Authorization');


//public route
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

//verify phone
Route::get('verify-phone/{phone}', 'UserController@verifyPhone');

//business types
Route::get('business-types','BusinessTypeController@index');

//protected route
Route::group(['middleware' => ['auth:sanctum']], function(){

    //authentication
    Route::post('user/update', 'AuthController@updateUserDetails');
    Route::post('logout', 'AuthController@logout');

    //reports
    Route::get('stats/campaign/{cid}','ReportController@getStats');
    Route::get('notice-board/campaign/{cid}','ReportController@getNoticeBoardContent');
    Route::get('trends/campaign/{cid}/user/{uid}','ReportController@getTrends');
    Route::get('locations/campaign/{cid}/user/{uid}','ReportController@getVisitedLocations');
    Route::get('top-products/campaign/{cid}/region/{rid}','ReportController@getDataByRegion');


    //regions
    Route::get('regions', 'RegionController@index');
 
    //districts
    Route::post('districts-add', 'DistrictController@insertDistrict');

    //roles
    Route::get('roles', 'RoleController@index');

    //sms
    Route::get('send-sms', 'UserController@sendSms');

    //users
    Route::get('users', 'UserController@index');
    Route::get('user/{uid}/stats', 'UserController@getUserStats');
    Route::get('users/campaign/{cid}', 'UserController@getUsersByCampaignId');
    Route::get('user/{uid}/campaign', 'UserController@getUserCampaign');
    Route::get('user/{uid}/business', 'UserController@getUserBusiness');
    Route::get('user/{uid}/customers','UserController@getUserCustomers');
    Route::get('user/{id}', 'UserController@show');
    Route::post('user', 'UserController@store');
    Route::delete('user/{uid}', 'UserController@destroy');

    //campaign type
    Route::get('campaign-types', 'CampaignTypeController@index');

    //campaign
    Route::post('campaign', 'CampaignController@store');

    //agents
    Route::get('agent-stats/campaign/{cid}', 'AgentController@getAgentsStatsByCampaignId');
    Route::get('agent/{uid}/num-customers', 'AgentController@getCustomersByAgentId');
    Route::get('agents/campaign/{cid}/region/{id}', 'AgentController@getAgentsByLocation');
    Route::post('agent/customer/stats', 'AgentController@markVisitation');
    
    //managers
    Route::get('managers','UserController@getManagers');

    //teams
    Route::get('teams','TeamController@getAllTeams');
    Route::get('teams/campaign/{cid}', 'TeamController@getTeamsByCampaignId');
    Route::post('team', 'TeamController@store');
    Route::delete('team/{id}', 'TeamController@destroy');

    //zones 
    Route::get('zones','ZoneController@getZones');

    //customers
    Route::get('customers','CustomerController@index');
    Route::get('customers/campaign/{bid}','CustomerController@getCustomersByCompaignId');
    Route::get('customer/locations/bussiness/{bid}','CustomerController@getCustomerLocationByBusinessId');
    Route::get('customers/teams','CustomerController@getTeamsCustomers');
    Route::post('customer','CustomerController@store');
    Route::get('customers/export', 'CustomerController@export');

    //business
    Route::get('business/user','BusinessController@getUserBusiness');
    Route::get('business/{bid}/campaigns','BusinessController@getBusinessCampaigns');


    //schedule
    Route::get('schedule/user','ScheduleController@index');

    //accounts
    Route::get('accounts', 'AccountController@index');

    //attendance
    Route::get('attendance/trends','AttendanceController@attendanceStats');
    Route::post('attendance', 'AttendanceController@store'); 

    //categories
    Route::get('categories','CategoryController@index');
    Route::get("categories/business/{id}", 'CategoryController@getBusinessCategories');
    Route::post("category", 'CategoryController@store');

    //products
    Route::get('products/business/{bid}/category/{cid}/special/{specialId}','ProductController@getBusinessProducts');
    Route::get('products/order/{orderId}','ProductController@getProductsByOrderId');
    Route::post('product/update','ProductController@update');
    Route::post('product','ProductController@store');
    Route::delete('product/{id}','ProductController@destroy');
  

    //skus
    Route::get('skus/business/{bid}', 'SkuController@getBusinessSku');

    //units
    Route::get('units/business/{bid}', 'UnitController@getBusinessUnits');

    //orders
    Route::get('orders', 'OrderController@index');
    Route::get('orders/campaign/{cid}', 'OrderController@getOrdersBycampaignId');
    Route::get('orders/campaign/{cid}/status/{status}', 'OrderController@getOrdersByStatus');
    Route::get('orders/user/{id}','OrderController@getUserOrders');
    Route::get('orders/user/{id}/date/{date}','OrderController@getUserOrdersByDate');
    Route::post('order', 'OrderController@store');
    Route::get('orders/export', 'OrderController@exportOrders');
    Route::post('order/{orderId}/status/{status}','OrderController@updateOrderStatus');

    //availabilities
    Route::get('availabilities', 'AvailabilityController@index');
    Route::post('availability', 'AvailabilityController@store');

}); 

