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

Route::post('/auth/login',['uses'=>'Auth\AuthController@login','desc'=>'Login'])->name('auth.login');
Route::post('/auth/register',['uses'=>'Auth\AuthController@register','desc'=>'Register'])->name('auth.register');
Route::get('storage/dir',['uses'=>'StorageController@listDir','desc'=>'List dir'])->name('storage.dir.list');
Route::get('storage/file',['uses'=>'StorageController@listFile','desc'=>'List file'])->name('storage.file.list');

//protected route

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('auth')->group(function (){
        Route::post('logout',['uses'=>'Auth\AuthController@logout','desc'=>'Logout'])->name('lauth.ogout');
        Route::post('refresh',['uses'=>'Auth\AuthController@refresh','desc'=>'Refresh token'])->name('token.refresh');
    });

    Route::get('me',['uses'=>'Acl\UserController@me','desc'=>'View self'])->name('self.view');

    // Access control
    Route::prefix('acl')->group(function (){
        //User
        Route::get('user',['uses'=>'Acl\UserController@index','desc'=>'List user'])->name('user.index');
        Route::post('user',['uses'=>'Acl\UserController@store','desc'=>'Create user'])->name('user.create');
        Route::get('user/{id}',['uses'=>'Acl\UserController@show','desc'=>'View user detail'])->where('id', '[0-9]+')->name('user.view');
        Route::put('user/{id}',['uses'=>'Acl\UserController@update','desc'=>'Update user'])->where('id', '[0-9]+')->name('user.edit');
        Route::delete('user/{id}',['uses'=>'Acl\UserController@destroy','desc'=>'Delete User'])->where('id', '[0-9]+')->name('user.delete');
        //Role
        Route::apiResource('role', 'Acl\RoleController');
    });
});

