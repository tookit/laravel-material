<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\Http\Controllers\Api\TaskController;
use Modules\Task\Models\Project;
use Modules\Task\Models\Task;

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

    Route::prefix('task')->group(function (){
        Route::get('/',[TaskController::class, 'index'])->name('task.index')->middleware(['can:task.list']);
        Route::post('/',[TaskController::class, 'store'])->name('task.create')->middleware(['can:task.create']);
        Route::get('/{id}',[TaskController::class, 'view'])->where('id', '[0-9]+')->name('task.view')->middleware(['can:task.view']);
        Route::put('/{id}',[TaskController::class, 'update'])->where('id', '[0-9]+')->name('task.edit')->middleware(['can:task.update']);
        Route::delete('/{id}',[TaskController::class, 'destroy'])->where('id', '[0-9]+')->name('task.delete')->middleware(['can:task.delete']);    

    });
    Route::prefix('project')->group(function (){

        Route::get('/',[Project::class, 'index'])->name('project.index')->middleware('can:project.list');
        Route::post('/',[Project::class, 'store'])->name('project.create')->middleware('can:project.create');
        Route::get('/{id}',[Project::class, 'view'])->where('id', '[0-9]+')->name('project.view')->middleware('can:project.view');
        Route::put('/{id}',[Project::class, 'update'])->where('id', '[0-9]+')->name('project.edit')->middleware('can:project.update');
        Route::delete('/{id}',[Project::class, 'destry'])->where('id', '[0-9]+')->name('project.delete')->middleware('can:project.delete');    

    });    

});