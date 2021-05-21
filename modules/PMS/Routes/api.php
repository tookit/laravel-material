<?php

use Illuminate\Support\Facades\Route;
use Modules\PMS\Http\Controllers\Api\ProjectController;
use Modules\PMS\Http\Controllers\Api\TaskController;

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

    Route::prefix('pms/task')->group(function (){
        Route::get('/',[TaskController::class, 'index'])->name('task.index')->middleware(['can:task.list']);
        Route::post('/',[TaskController::class, 'store'])->name('task.create')->middleware(['can:task.create']);
        Route::get('/{id}',[TaskController::class, 'show'])->where('id', '[0-9]+')->name('task.view')->middleware(['can:task.view']);
        Route::put('/{id}',[TaskController::class, 'update'])->where('id', '[0-9]+')->name('task.edit')->middleware(['can:task.update']);
        Route::delete('/{ids}',[TaskController::class, 'destroy'])->name('task.delete')->middleware(['can:task.delete']);    

    });

    Route::prefix('pms/project')->group(function (){
        Route::get('/',[ProjectController::class, 'index'])->name('project.index')->middleware(['can:project.list']);
        Route::get('/status',[ProjectController::class, 'getStatus'])->name('project.getStatus')->middleware(['can:project.getStatus']);
        Route::post('/',[ProjectController::class, 'store'])->name('project.create')->middleware(['can:project.create']);
        Route::get('/{id}',[ProjectController::class, 'show'])->where('id', '[0-9]+')->name('project.view')->middleware(['can:project.view']);
        Route::put('/{id}',[ProjectController::class, 'update'])->where('id', '[0-9]+')->name('project.edit')->middleware(['can:project.update']);
        Route::delete('/{ids}',[ProjectController::class, 'destroy'])->name('project.delete')->middleware(['can:project.delete']);    

    });

});