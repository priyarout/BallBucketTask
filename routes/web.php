<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'BallBucketController@index')->name('index');
Route::post('/store-bucket', 'BallBucketController@createBucket')->name('createBucket');
Route::post('/store-ball', 'BallBucketController@createBall')->name('createBall');

Route::post('/store-suggested-balls', 'BallBucketController@storeSuggestedBalls')->name('storeSuggestedBalls');
