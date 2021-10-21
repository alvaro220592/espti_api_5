<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\Api\ProductController;

$this->group(['prefix' => 'v1'], function(){

    $this->post('auth', 'Auth\AuthApiController@authenticate');

    $this->group(['middleware' => 'jwt.auth'], function(){
        $this->resource('products', 'Api\ProductController');
        $this->post('products/search/', 'Api\ProductController@search');
    });
});