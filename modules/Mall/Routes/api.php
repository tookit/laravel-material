<?php

use Illuminate\Support\Facades\Route;
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
        
        Route::get('/',[ItemController::class, 'index'])->name('item.index')->middleware(['can:item.list']);
        Route::post('/',[ItemController::class, 'store'])->name('item.create')->middleware(['can:item.create']);
        Route::get('/{id}',[ItemController::class, 'show'])->where('id', '[0-9]+')->name('item.view')->middleware(['can:item.view']);
        Route::put('/{id}',[ItemController::class, 'update'])->where('id', '[0-9]+')->name('item.edit')->middleware(['can:item.update']);
        Route::delete('/{ids}',[ItemController::class, 'destroy'])->name('item.delete')->middleware(['can:item.delete']);    

    });



});