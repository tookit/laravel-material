<?php

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
Route::middleware([])->group(function () {

    Route::prefix('task')->group(function (){

        Route::get('/',['uses'=>'TaskController@index','desc'=>'List task'])->name('task.index');
        Route::post('/',['uses'=>'TaskController@store','desc'=>'Create task'])->name('task.create');
        Route::get('/{id}',['uses'=>'TaskController@show','desc'=>'View task detail'])->where('id', '[0-9]+')->name('task.view');
        Route::put('/{id}',['uses'=>'TaskController@update','desc'=>'Update task'])->where('id', '[0-9]+')->name('task.edit');
        Route::delete('/{id}',['uses'=>'TaskController@destroy','desc'=>'Delete task'])->where('id', '[0-9]+')->name('task.delete');    

    });
    Route::prefix('project')->group(function (){

        Route::get('/',['uses'=>'ProjectController@index','desc'=>'List project'])->name('project.index');
        Route::post('/',['uses'=>'ProjectController@store','desc'=>'Create project'])->name('project.create');
        Route::get('/{id}',['uses'=>'ProjectController@show','desc'=>'View project detail'])->where('id', '[0-9]+')->name('project.view');
        Route::put('/{id}',['uses'=>'ProjectController@update','desc'=>'Update project'])->where('id', '[0-9]+')->name('project.edit');
        Route::delete('/{id}',['uses'=>'ProjectController@destroy','desc'=>'Delete project'])->where('id', '[0-9]+')->name('project.delete');    

    });    

});