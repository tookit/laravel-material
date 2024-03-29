<?php

use Illuminate\Support\Facades\Route;
use Modules\Mall\Http\Controllers\Api\BrandController;
use Modules\Mall\Http\Controllers\Api\CategoryController;
use Modules\Mall\Http\Controllers\Api\ItemController;
use Modules\Mall\Http\Controllers\Api\PropertyController;

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
        Route::get('/{id}',[ItemController::class, 'show'])->name('mall.item.view')->middleware(['can:mall.item.view'])->where('id', '[0-9]+');
        Route::put('/{id}',[ItemController::class, 'update'])->name('mall.item.edit')->middleware(['can:mall.item.update'])->where('id', '[0-9]+');
        Route::put('/{id}/value',[ItemController::class, 'attachValue'])->name('mall.item.attachValue')->middleware(['can:mall.item.attachValue'])->where('id', '[0-9]+');
        Route::put('/{id}/detail',[ItemController::class, 'updateDetail'])->name('mall.item_detail.edit')->middleware(['can:mall.item_detail.update'])->where('id', '[0-9]+');
        Route::delete('/{ids}',[ItemController::class, 'destroy'])->name('mall.item.delete')->middleware(['can:mall.item.delete']);    

    });

    Route::prefix('mall/category')->group(function (){
        
        Route::get('/',[CategoryController::class, 'index'])->name('mall.category.index')->middleware(['can:mall.category.list']);
        Route::post('/',[CategoryController::class, 'store'])->name('mall.category.create')->middleware(['can:mall.category.create']);
        Route::get('/{id}',[CategoryController::class, 'show'])->name('mall.category.view')->middleware(['can:mall.category.view'])->where('id', '[0-9]+');
        Route::put('/{id}',[CategoryController::class, 'update'])->name('mall.category.edit')->middleware(['can:mall.category.update'])->where('id', '[0-9]+');
        Route::put('/{id}/property',[CategoryController::class, 'attachProperty'])->name('mall.category.attachProperty')->middleware(['can:mall.category.attachProperty'])->where('id', '[0-9]+');
        Route::delete('/{ids}',[CategoryController::class, 'destroy'])->name('mall.category.delete')->middleware(['can:mall.category.delete']);    

    });


    Route::prefix('mall/brand')->group(function (){
        
        Route::get('/',[BrandController::class, 'index'])->name('mall.brand.index')->middleware(['can:mall.brand.list']);
        Route::post('/',[BrandController::class, 'store'])->name('mall.brand.create')->middleware(['can:mall.brand.create']);
        Route::get('/{id}',[BrandController::class, 'show'])->name('mall.brand.view')->middleware(['can:mall.brand.view'])->where('id', '[0-9]+');
        Route::put('/{id}',[BrandController::class, 'update'])->name('mall.brand.edit')->middleware(['can:mall.brand.update'])->where('id', '[0-9]+');
        Route::delete('/{ids}',[BrandController::class, 'destroy'])->name('mall.brand.delete')->middleware(['can:mall.brand.delete']);    

    });


    Route::prefix('mall/property')->group(function (){
        
        Route::get('/',[PropertyController::class, 'index'])->name('mall.property.index')->middleware(['can:mall.property.list']);
        Route::post('/',[PropertyController::class, 'store'])->name('mall.property.create')->middleware(['can:mall.property.create']);
        Route::get('/{id}',[PropertyController::class, 'show'])->name('mall.property.view')->middleware(['can:mall.property.view'])->where('id', '[0-9]+');
        Route::put('/{id}',[PropertyController::class, 'update'])->name('mall.property.edit')->middleware(['can:mall.property.update'])->where('id', '[0-9]+');
        Route::delete('/{ids}',[PropertyController::class, 'destroy'])->name('mall.property.delete')->middleware(['can:mall.property.delete']);    

    });


});