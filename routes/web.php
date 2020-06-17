<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Auth::routes();  

Route::prefix('backend')->group(function () {
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Auth\LoginController@login');

    Route::middleware(['auth:web', 'rolecheck'])->group( function () {
        Route::get('kelas/datatable','Backend\KelasController@datatable')->name('kelas.datatable');
        Route::get('matapelajaran/datatable','Backend\MatapelajaranController@datatable')->name('matapelajaran.datatable');
        Route::get('user/datatable','Backend\UserController@datatable')->name('user.datatable');
        Route::post('user/changepassword/{id}', 'Backend\UserController@changepassword')->name('user.changepassword');
        Route::post('user/resetpassword','Backend\UserController@resetpassword')->name('user.resetpassword');
        Route::get('user/kelas/{id}','Backend\MlearningsiswaController@kelasmlearning')->name('mlearningsiswa.kelas');
        Route::get('mlearning/datatable','Backend\MlearningController@datatable')->name('mlearning.datatable');
        Route::get('mlearningmateri/datatable/{id}','Backend\MlearningmateriController@datatable')->name('mlearningmateri.datatable');
        Route::get('mlearningmateri/materi/{id}','Backend\MlearningmateriController@materi')->name('mlearningmateri.materi');
        Route::get('mlearningmateri/materi/{id}/create','Backend\MlearningmateriController@createmateri')->name('mlearningmateri.createmateri');
        Route::get('mlearningmateri/materi/{id}/edit','Backend\MlearningmateriController@editmateri')->name('mlearningmateri.editmateri');
        Route::put('mlearningmateri/materi/{id}/updatemateri','Backend\MlearningmateriController@updatemateri')->name('mlearningmateri.updatemateri');
        Route::get('mlearningmateri/komentar/{id}','Backend\MlearningkomentarController@komentar')->name('mlearningkomentar.komentar');

        Route::resource('dashboard', 'Backend\DashboardController');
        Route::resource('kelas', 'Backend\KelasController');
        Route::resource('matapelajaran', 'Backend\MatapelajaranController');
        Route::resource('user', 'Backend\UserController');
        Route::resource('mlearning', 'Backend\MlearningController');
        Route::resource('mlearningsiswa', 'Backend\MlearningsiswaController');
        Route::resource('mlearningmateri', 'Backend\MlearningmateriController');
        Route::resource('mlearningkomentar', 'Backend\MlearningkomentarController');
    });

});

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
