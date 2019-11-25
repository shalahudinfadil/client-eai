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

Route::get('/','AuthController@welcome');

Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');
Route::get('/logout','AuthController@logout');

Route::middleware(['authclient'])->group(function(){
  Route::get('/dashboard','ClientController@dashboard');
  Route::get('/ticket','ClientController@ticket');
  Route::get('/ticket/{id}','ClientController@getTicket');
  Route::get('/new','ClientController@newTicket');
  Route::get('/submodul/{id}','ClientController@getSubmodules');
  Route::post('/new','ClientController@postTicket');
  Route::view('/settings','settings');
  Route::post('/update','ClientController@updateInfo');
  Route::post('/password','ClientController@changePassword');

  Route::get('/tickets/client','ClientController@getClientTickets');
  Route::get('/tickets/pic','ClientController@getPICTickets');
});
