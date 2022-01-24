<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

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

Route::get('/calendar/{year}/{month}', 'CalendarController@show')->name('calendar.show')->middleware('auth');

Route::get('/events/create', 'EventController@create')->name('events.create');
Route::post('/events', 'EventController@store')->name('events.store');
// Route::get('/events/{event}', 'EventController@show')->name('events.show');
Route::get('/events/{event}/edit', 'EventController@edit')->name('events.edit');
Route::post('/events/{event}', 'EventController@update')->name('events.update');
Route::delete('/events/{event}', 'EventController@destroy')->name('events.destroy');

// '/' にアクセスした時に今月の月のカレンダーにリダイレクト
Route::get('/', function () {
    return redirect()->route('calendar.show', ['year' => Carbon::now()->year, 'month' => Carbon::now()->month]);
});
