<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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

Auth::routes();

//CalendarController
Route::get('/calendar/{year}/{month}', 'CalendarController@show')->name('calendar.show')->middleware('auth');

// '/' にアクセスした時に今月の月のカレンダーにリダイレクト
Route::get('/', function() {
    return redirect()->route('calendar.show', ['year' => Carbon::now()->year, 'month' => Carbon::now()->month]);
});

//EventController
Route::get('/events/create', 'EventController@create')->name('events.create');
Route::post('/events', 'EventController@store')->name('events.store');
Route::get('/events/{id}', 'EventController@show')->name('events.show');
Route::get('/events/{id}/edit', 'EventController@edit')->name('events.edit');
Route::post('/events/{id}', 'EventController@update')->name('events.update');
Route::delete('/events/{id}', 'EventController@destroy')->name('events.destroy');
