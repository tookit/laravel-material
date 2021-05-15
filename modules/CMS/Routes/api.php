<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\Api\PostController;

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


Route::middleware(['auth:api'])->group(function () {

    Route::prefix('cms')->group(function (){

        Route::get('/post',[PostController::class, 'index'])->name('post.index');
        Route::post('post',[PostController::class,'store'])->name('post.create');
        Route::get('post/{id}',[PostController::class, 'view'])->where('id', '[0-9]+')->name('post.view');
        Route::put('post/{id}',[PostController::class, 'update'])->where('id', '[0-9]+')->name('post.edit');
        Route::delete('post/{id}',[PostController::class, 'destroy'])->where('id', '[0-9]+')->name('post.delete');    

        Route::apiResource('category','CategoryController');
        Route::get('/tag/type',['uses'=>'TagController@getType','desc'=>'List tag type'])->name('tag.type.list');
        Route::apiResource('tag','TagController');

    });

});