<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\Api\ProductController;

Route::group(['prefix' => 'v1'], function(){
    Route::group(['middleware' => 'jwt.auth'], function(){
        Route::resource('products', 'Api\ProductController');
        Route::post('products/search/', 'Api\ProductController@search');
    });
});