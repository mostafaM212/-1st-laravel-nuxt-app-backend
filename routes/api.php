<?php

use Illuminate\Http\Request;

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

Route::post('register','AuthController@register') ;

Route::post('/login','AuthController@login') ;

Route::get('/user','AuthController@user') ;

Route::post('/logout','AuthController@logout') ;

Route::group(['prefix' => 'topics'],function (){

    Route::post('/','TopicController@store')->middleware('auth:api');

    Route::get('/','TopicController@index');

    Route::get('/{topic}','TopicController@show');

    Route::put('/{topic}','TopicController@update')->middleware('auth:api');

    Route::delete('/{topic}','TopicController@destroy')->middleware('auth:api');

    Route::group(['prefix'=>'/{topic}/posts' , 'middleware'=>'auth:api'],function (){

        Route::get('/{post}','PostController@show') ;

        Route::post('/','PostController@store') ;

        Route::put('/{post}','PostController@update') ;

        Route::delete('/{post}','PostController@destroy') ;
    });

    //likes

    Route::group(['prefix'=>'/{post}/likes','middleware'=>'auth:api'],function (){

        Route::post('/','PostLikeController@store') ;
    });
});


