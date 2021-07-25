<?php

use Illuminate\Support\Facades\Route;
use Modules\Mall\Http\Controllers\Api\CategoryController;
use Modules\Mall\Http\Controllers\Api\ItemController;

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

    Route::prefix('mall/item')->group(function (){
        
        Route::get('/',[ItemController::class, 'index'])->name('mall.item.index')->middleware(['can:mall.item.list']);
        Route::post('/',[ItemController::class, 'store'])->name('mall.item.create')->middleware(['can:mall.item.create']);
        Route::get('/{id}',[ItemController::class, 'show'])->where('id', '[0-9]+')->name('mall.item.view')->middleware(['can:mall.item.view']);
        Route::put('/{id}',[ItemController::class, 'update'])->where('id', '[0-9]+')->name('mall.item.edit')->middleware(['can:mall.item.update']);
        Route::delete('/{ids}',[ItemController::class, 'destroy'])->name('mall.item.delete')->middleware(['can:mall.item.delete']);    

    });

    Route::prefix('mall/category')->group(function (){
        
        Route::get('/',[CategoryController::class, 'index'])->name('mall.category.index')->middleware(['can:mall.category.list']);
        Route::post('/',[CategoryController::class, 'store'])->name('mall.item.create')->middleware(['can:mall.category.create']);
        Route::get('/{id}',[CategoryController::class, 'show'])->where('id', '[0-9]+')->name('mall.category.view')->middleware(['can:mall.category.view']);
        Route::put('/{id}',[CategoryController::class, 'update'])->where('id', '[0-9]+')->name('mall.category.edit')->middleware(['can:mall.category.update']);
        Route::delete('/{ids}',[CategoryController::class, 'destroy'])->name('mall.category.delete')->middleware(['can:mall.category.delete']);    

    });



});