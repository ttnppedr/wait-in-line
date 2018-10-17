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

Route::post('/register', 'RegistrationController@store');

Route::post('/login', 'LoginController@store');

Route::middleware('auth:api')->group(function () {
    Route::get('/cards', 'CardController@show');
    Route::get('/cards/{user}', 'CardController@showUser');
    Route::post('/cards/{user}', 'CardController@store');
    Route::delete('/cards', 'CardController@destroy');
    Route::patch('/cards', 'CardController@update');

    Route::get('/desks', 'DeskController@index');
});
