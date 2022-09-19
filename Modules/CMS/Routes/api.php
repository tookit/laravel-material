<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\Api\CategoryController;
use Modules\CMS\Http\Controllers\Api\PostController;
use Modules\CMS\Http\Controllers\Api\TagController;

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

        //post
        Route::prefix('post')->group(function(){
            Route::get('/',[PostController::class, 'index'])->name('post.list')->middleware('can:post.list');
            Route::post('/',[PostController::class, 'store'])->name('post.create')->middleware('can:post.create');
            Route::get('/{id}',[PostController::class, 'show'])->where('id', '[0-9]+')->name('post.view')->middleware('can:post.view');
            Route::put('/{id}',[PostController::class,'update'])->where('id', '[0-9]+')->name('post.edit')->middleware('can:post.edit');
            Route::delete('/{ids}',[PostController::class, 'destroy'])->name('post.delete')->middleware('can:post.delete');
        });

        Route::prefix('category')->group(function(){
            Route::get('/',[CategoryController::class, 'index'])->name('category.list')->middleware('can:category.list');
            Route::post('/',[CategoryController::class, 'store'])->name('category.create')->middleware('can:category.create');
            Route::get('/{id}',[CategoryController::class, 'show'])->where('id', '[0-9]+')->name('category.view')->middleware('can:category.view');
            Route::put('/{id}',[CategoryController::class,'update'])->where('id', '[0-9]+')->name('category.edit')->middleware('can:category.edit');
            Route::delete('/{ids}',[CategoryController::class, 'destroy'])->name('category.delete')->middleware('can:category.delete');
        });        



        Route::prefix('tag')->group(function(){
            Route::get('/',[TagController::class, 'index'])->name('tag.list')->middleware('can:tag.list');
            Route::get('/type',[TagController::class, 'getType'])->name('tag.list')->middleware('can:tag.listType');
            Route::post('/',[TagController::class, 'store'])->name('tag.create')->middleware('can:tag.create');
            Route::get('/{id}',[TagController::class, 'show'])->where('id', '[0-9]+')->name('tag.view')->middleware('can:tag.view');
            Route::put('/{id}',[TagController::class,'update'])->where('id', '[0-9]+')->name('tag.edit')->middleware('can:tag.edit');
            Route::delete('/{ids}',[TagController::class, 'destroy'])->name('tag.delete')->middleware('can:tag.delete');
        }); 
        
        

    });

});