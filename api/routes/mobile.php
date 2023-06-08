<?php
use Illuminate\Support\Facades\Route;

//products
Route::get( 'products/business/{bid}/category/{cid}/special/{specialId}', 'ProductController@getBusinessProducts' );

//categories
Route::get( 'categories/business/{id}', 'CategoryController@getBusinessCategories' );

//skus
Route::get( 'skus/business/{bid}/product/{pid}', 'SkuController@getBusinessProductSku' );

//visitation
Route::post('agent/customer/stats', 'AgentController@markVisitation');

 //customers
 Route::get('customer/user/{uid}','CustomerController@getCustomerByUserid');

 //regions
 Route::get('regions-districts','RegionController@getRegionDistricts');

 //register user as customer
 Route::post('user','UserController@storeUserCustomer');

    
