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
    return view('welcome');
});

Route::get('q&a', function () {
    return view('q&a');
})->name('q&a');

Route::get('conditions', function () {
    return view('conditions');
})->name('conditions');

Route::get('webhook', 'WebhookController@index');

Route::post('webhook', 'WebhookController@show');