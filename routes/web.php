<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OtpController;
use Illuminate\Http\Request;
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
    return redirect('/dashboard');
});

Route::group(['middleware'=>['otp', 'auth']], function(){
    Route::get('/dashboard', function(Request $request) {
        $user = $request->user();
        return view('dashboard', ['username'=> $user->name]);
    });
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/login/otp', [OtpController::class, 'index'])->name('login.otp');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/login/otp', [OtpController::class, 'validateOtp'])->name('validate.otp');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');