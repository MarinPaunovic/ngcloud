<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
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
Route::controller(LoginRegisterController::class)->group(function(){
Route::get('/register', 'register')->name('register');
Route::get('/login', 'login')->name('login');
Route::post('/authenticate', 'authenticate')->name('authenticate');  
});


Route::group(['middleware' => 'auth'], function () { 
    Route::view('/', 'home')->name('homepage');
    Route::view('/profile','profile')->name('profile');
    Route::controller(LoginRegisterController::class)->group(function(){
        Route::post('/store', 'store')->name('store');
        Route::get('/logout', 'logout')->name('logout');
    });
    Route::controller(PhotoController::class)->group(function(){
        Route::delete('/photos/{filename}','destroy')->name('photos.destroy');
        Route::get('/photos/download/{filename}', function (){
            return redirect()->route('homepage');
        });
        Route::post('/photos/download/{filename}','download')->name('photos.download');
        Route::post('/photos/upload','upload')->name('photos.upload');
    });
});

Route::fallback(function(){
    return redirect()->route('homepage');
});