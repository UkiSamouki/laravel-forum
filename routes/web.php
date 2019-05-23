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
    return view('welcome');
});
  
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadController@index');
Route::get('/threads/create', 'ThreadController@create');
Route::post('/threads', 'ThreadController@store'); 
Route::get('/threads/{chanel}/{thread}', 'ThreadController@show');
Route::delete('/threads/{chanel}/{thread}', 'ThreadController@destroy');
//Route::resource('/threads', 'ThreadController');
Route::get('/threads/{chanel}', 'ThreadController@index'); 
Route::post('/threads/{chanel}/{thread}/replies', 'ReplayController@store'); 

Route::delete('/replies/{replay}', 'ReplayController@destroy');
Route::patch('/replies/{replay}', 'ReplayController@update');
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

Route::post('/replies/{replay}/favorites', 'FavoritesController@store');
Route::delete('/replies/{replay}/favorites', 'FavoritesController@destroy');


