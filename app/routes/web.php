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

Route::get('/', function () {
    return view('index');
});


Route::get('/welcome', function () {
    return view('index');
});


Route::get('/hello', 'HelloController@index');

Route::get('/artists', 'ArtistsController@index');

Route::get('/ranking', 'RankingController@index');

