<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\Api\ProductController;

$this->group(['prefix' => 'v1'], function(){

    $this->post('auth', 'Auth\AuthApiController@authenticate');
    $this->get('auth-refresh', 'Auth\AuthApiController@refreshToken');

    $this->group(['middleware' => 'jwt.auth'], function(){
        $this->resource('products', 'Api\ProductController');
        $this->get('products/search/', 'Api\ProductController@search');
    });
});