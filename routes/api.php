<?php

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\Users;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Laravel\Octane\Facades\Octane;

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
Route::post('/users/signup', [Users::class, 'signup']);
Route::post('/users/login', [Users::class, 'login']);

//Octane::route('POST','/users/signup',function ($request) {return new Response((new Users)->signup($request));});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get("/users/{id}", [Users::class, 'show']);
    Route::get("/holidays", [HolidaysController::class, 'index']);
    Route::get("/holidays/{id}", [HolidaysController::class, 'show']);
    Route::get("/regions", [RegionsController::class, 'index']);
    Route::get("/regions/{id}", [RegionsController::class, 'show']);
    Route::get("/countries", [CountriesController::class, 'index']);
    Route::get("/countries/{id}", [CountriesController::class, 'show']);
});
