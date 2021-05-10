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


Route::middleware(['auth:api'])->group(function () {

    Route::prefix('cms')->group(function (){

        Route::get('/post',['uses'=>'PostController@index','desc'=>'List post'])->name('post.index');
        Route::post('post',['uses'=>'PostController@store','desc'=>'Create post'])->name('post.create');
        Route::get('post/{id}',['uses'=>'PostController@show','desc'=>'View post detail'])->where('id', '[0-9]+')->name('post.view');
        Route::put('post/{id}',['uses'=>'PostController@update','desc'=>'Update post'])->where('id', '[0-9]+')->name('post.edit');
        Route::delete('post/{id}',['uses'=>'PostController@destroy','desc'=>'Delete post'])->where('id', '[0-9]+')->name('post.delete');    

        Route::apiResource('category','CategoryController');
        Route::get('/tag/type',['uses'=>'TagController@getType','desc'=>'List tag type'])->name('tag.type.list');
        Route::apiResource('tag','TagController');

    });

});