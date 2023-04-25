<?php
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\ProfileController;
use App\Models\Admin;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Password;
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

Route::group(["middleware"=>"guest"],function(){
    Route::get('/forgot-password',[PasswordController::class, 'request'])->name('password.request');
    Route::post('/forgot-password',[PasswordController::class,'resetLink'])->name('password.email');
    Route::get('/reset-password/{token}',[PasswordController::class,'reset'])->name('password.reset');
    Route::post('/reset-password',[PasswordController::class,'newPassword'])->name('password.update');
});


Route::group(["middleware"=>"admin"],function(){
    Route::get('/users',[UserController::class,'index'])->name('users');
});

Route::controller(LoginRegisterController::class)->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');  
});


Route::group(['middleware' => 'auth'], function () { 
    Route::get('/', [PhotoController::class,'index'])->name('homepage');
    
    Route::prefix('profile')->group(function(){
        Route::name('profile')->group(function(){
            Route::controller(ProfileController::class)->group(function(){
                Route::get('','index');
                Route::post('/update','update')->name('.update');
            });
        });
    });

    Route::controller(LoginRegisterController::class)->group(function(){
        Route::get('/logout', 'logout')->name('logout');
    });
    
    Route::prefix('photos')->group(function(){
        Route::name('photos.')->group(function(){
            Route::controller(PhotoController::class)->group(function(){
                Route::get('/download/{filename}', function (){
                    return redirect()->route('homepage');
                });
                Route::delete('/{filename}','destroy')->name('destroy');
                Route::post('/download/{filename}','download')->name('download');
                Route::post('/upload','upload')->name('upload');
            });
        });
    });
});

Route::fallback(function(){
    return redirect()->route('homepage');
});