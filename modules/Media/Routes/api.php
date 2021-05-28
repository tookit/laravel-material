<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\Api\MediaController;

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
    // media
    Route::prefix('media')->group(function(){
        Route::get('/',[MediaController::class, 'index'])->name('file.list')->middleware('can:file.list');
        Route::get('/type',[MediaController::class, 'getTypes'])->name('file.getTypes')->middleware('can:file.getTypes');
        Route::get('/directory',[MediaController::class, 'getDirectory'])->name('file.getDirectory')->middleware('can:file.getDirectory');
        Route::post('/directory',[MediaController::class, 'createDirectory'])->name('file.createDirectory')->middleware('can:file.createDirectory');
        Route::get('/{id}',[MediaController::class, 'show'])->where('id', '[0-9]+')->name('file.view')->middleware('can:file.view');
        Route::post('/',[MediaController::class, 'store'])->name('file.create')->middleware('can:file.create');
        Route::delete('/{ids}',[MediaController::class, 'destroy'])->name('file.delete')->middleware('can:file.delete');
    });



});