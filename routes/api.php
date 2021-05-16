<?php

use App\Http\Controllers\Api\Acl\PermissionController;
use App\Http\Controllers\Api\Acl\RoleController;
use App\Http\Controllers\Api\Acl\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

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
        Route::post('logout',[AuthController::class,'logout'])->name('auth.logout');
        Route::post('refresh',[AuthController::class, 'refresh'])->name('token.refresh');
    });

    Route::get('me',[UserController::class, 'getProfile'])->name('self.view');
    Route::post('me',[UserController::class, 'updateProfile'])->name('self.view');
    // Access control
    Route::prefix('acl')->group(function (){
        
        //User
        Route::prefix('user')->group(function(){
            Route::get('/',[UserController::class, 'index'])->name('user.list')->middleware('can:user.list');
            Route::post('/',[UserController::class, 'store'])->name('user.create')->middleware('can:user.create');
            Route::get('/{id}',[UserController::class, 'show'])->where('id', '[0-9]+')->name('user.view')->middleware('can:user.view');
            Route::put('/{id}',[UserController::class,'update'])->where('id', '[0-9]+')->name('user.edit')->middleware('can:user.edit');
            Route::post('/{id}/permission',[UserController::class, 'attachPermission'])->where('id', '[0-9]+')->name('user.attachPermission')->middleware('can:user.attachPermission');
            Route::post('/{id}/role',[UserController::class,'assignRole'])->where('id', '[0-9]+')->name('user.assignRole')->middleware('can:user.assignRole');
            Route::delete('/{id}',[UserController::class, 'destroy'])->where('id', '[0-9]+')->name('user.delete')->middleware('can:user.delete');
        });

        //Role
        Route::prefix('role')->group(function(){
            Route::get('/',[RoleController::class, 'index'])->name('role.list')->middleware('can:role.list');
            Route::post('/',[RoleController::class, 'store'])->name('role.create')->middleware('can:role.create');
            Route::get('/{id}',[RoleController::class, 'show'])->where('id', '[0-9]+')->name('role.view')->middleware('can:role.view');
            Route::put('/{id}',[RoleController::class,'update'])->where('id', '[0-9]+')->name('role.edit')->middleware('can:role.edit');
            Route::post('/{id}/permission',[RoleController::class, 'attachPermission'])->where('id', '[0-9]+')->name('role.attachPermission')->middleware('can:role.attachPermission');
            Route::delete('/{id}',[RoleController::class, 'destroy'])->where('id', '[0-9]+')->name('role.delete')->middleware('can:role.delete');
        });

        //Permission
        Route::prefix('permission')->group(function() {

            Route::get('/',[PermissionController::class,'index'])->name('permission.list')->middleware('can:permission.list');
            Route::post('/',[PermissionController::class, 'store'])->name('permission.create')->middleware('can:permission.create');
            Route::get('/{id}',[PermissionController::class, 'show'])->where('id', '[0-9]+')->name('permission.view')->middleware('can:permission.view');
            Route::put('/{id}',[PermissionController::class, 'update'])->where('id', '[0-9]+')->name('permission.edit')->middleware('can:permission.edit');
            Route::delete('/{id}',[PermissionController::class, 'destroy'])->where('id', '[0-9]+')->name('permission.delete')->middleware('can:permission.delete');
        });

    });
});

