<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\Api\ProductController;

Route::group(['prefix' => 'v1'], function(){
    Route::resource('products', 'Api\ProductController');
});