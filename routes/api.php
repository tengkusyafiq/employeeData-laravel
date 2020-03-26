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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');

Route::group(['namespace' => 'Api\v1', 'prefix' => 'v1', 'as' => 'v1.'], function () {
    // get employee data, use apiResource to make it restful
    Route::apiResource('employee', 'EmployeeController')->middleware('auth:api');
    Route::post('employee/import', 'EmployeeController@import')->name('employee.import')->middleware('auth:api');
});
