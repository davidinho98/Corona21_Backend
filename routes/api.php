<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccinationController;
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

Route::get('locations',[LocationController::class,'index']);
Route::get('locations/{id}', [LocationController::class, 'findById']);
Route::get('location/{plz}',[LocationController::class,'findByPLZ']);
Route::get('locations/checkplz/{plz}',[LocationController::class,'checkPLZ']);
Route::get('locations/search/{searchTerm}', [LocationController::class, 'findBySearchTerm']);
//vaccinations:
Route::get('vaccinations', [VaccinationController::class, 'index']);
Route::get('vaccinations/{id}', [VaccinationController::class, 'findById']);
Route::get('users/search/{id}', [UserController::class, 'findById']);

Route::post('auth/login',[AuthController::class,'login']);

/*
//Location:
Route::post('location',[LocationController::class,'save']);
Route::put('locations/{id}',[LocationController::class,'update']);
Route::delete('locations/{id}',[LocationController::class,'delete']);
//Vaccination:
Route::post('vaccinations', [VaccinationController::class, 'save']);
Route::put('vaccinations/{id}', [VaccinationController::class, 'update']);
Route::delete('vaccinations/{id}', [VaccinationController::class, 'delete']);
//User:
Route::get('users', [UserController::class, 'index']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'delete']);
Route::post('users', [UserController::class, 'save']);*/

// Hier alle Routen rein, die nur für authentifizierte User sind

Route::group(['middleware'=>['api','auth.jwt']],function(){
    //Location:
    Route::post('location',[LocationController::class,'save']);
    Route::put('locations/{id}',[LocationController::class,'update']);
    Route::delete('locations/{id}',[LocationController::class,'delete']);
    //Vaccination:
    Route::post('vaccinations', [VaccinationController::class, 'save']);
    Route::put('vaccinations/{id}', [VaccinationController::class, 'update']);
    Route::delete('vaccinations/{id}', [VaccinationController::class, 'delete']);
    //User:
    Route::get('users', [UserController::class, 'index']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'delete']);
    Route::post('users', [UserController::class, 'save']);
    //Auth:
    Route::post('auth/logout',[AuthController::class,'logout']);
});
