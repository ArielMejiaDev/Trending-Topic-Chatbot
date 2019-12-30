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

use Thujohn\Twitter\Facades\Twitter;

Route::get('/', function () {
    //return view('welcome');
    return Twitter::getTrendsAvailable();
});

Route::get('berlin', function () {
    return Twitter::getTrendsPlace(['id' => '638242']);
});

Route::get('webhook', 'WebhookController@index');

Route::post('webhook', 'WebhookController@show');