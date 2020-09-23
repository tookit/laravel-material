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


//public route

Route::post('/auth/login',['uses'=>'Auth\LoginController@login','desc'=>'Login'])->name('auth.login');


//protected route

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('auth')->group(function (){
        Route::post('logout',['uses'=>'Auth\LoginController@logout','desc'=>'Logout'])->name('lauth.ogout');
        Route::post('refresh',['uses'=>'Auth\LoginController@refresh','desc'=>'Refresh token'])->name('token.refresh');
    });

    Route::get('me',['uses'=>'Acl\UserController@me','desc'=>'View self'])->name('self.view');
});

