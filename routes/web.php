<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Location;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $locations = DB::table('locations')->get();
    return view('welcome',compact('locations'));
});

Route::get('/locations', function () {
    $locations = \App\Models\Location::all();
    //$locations = DB::table('locations')->get();
    return view('locations.index',compact('locations'));
});

Route::get('/locations/{id}', function ($id) {
    $location = DB::table('locations')->find($id);
    return view('locations.show',compact('location'));
});
