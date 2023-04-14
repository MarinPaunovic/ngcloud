<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;



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

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/', 'homepage')->name('homepage');
    Route::get('/logout', 'logout')->name('logout');;
    Route::controller(PhotoController::class)->group(function(){
        Route::post('/photos','store');
        Route::get('/photos/create','create');
        Route::delete('/photos/{filename}','destroy');
        Route::post('/photos/upload','upload');
    });
});
