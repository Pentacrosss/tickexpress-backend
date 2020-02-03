<?php

use Illuminate\Http\Request;

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
Route::post('/searchRutas', 'RutasController@searchRutas');
Route::post('/searchRutasbyPlace', 'RutasController@searchRutasbyPlaces');
Route::get('/listRutas', 'RutasController@listRutas');
Route::post('/registerRuta', 'RutasController@registerRuta');
Route::post('/registerUser', 'RutasController@registerUser');
Route::post('/login', 'RutasController@login');
Route::get('/listBuses', 'RutasController@buses');
Route::get('/listCooperativas', 'RutasController@cooperativas');
Route::post('/registerBuses', 'RutasController@registerBuses');
Route::post('/registerDestinos', 'RutasController@registerDestinos');
Route::get('/listLugares', 'RutasController@listLugares');