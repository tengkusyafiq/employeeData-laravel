<?php

use App\Employee;
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

// test static employee
Route::get('/staticemployee', function () {
    return [
        'first_name' => 'John',
        'last_name' => 'Wick',
    ];
});

// get one employee data by id.
Route::get('/employee/{employee}', function (Employee $employee) {
    return $employee;
});
