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
    return $request->user()->setVisible(['api_token']);
});

Route::post('/user/register', 'API\UserController@register');
Route::post('/user/login', 'API\UserController@login');
Route::get('/kelas/listkelas', 'API\KelasController@kelas');

Route::middleware('auth:api')->group( function (){
    Route::resource('kelas', 'API\KelasController');
    Route::get('/user/kelas', 'API\UserController@kelas');
    Route::get('/materi/{id}', 'API\MateriController@materi');

});


