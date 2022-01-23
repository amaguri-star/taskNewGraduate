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

Route::prefix('/calendar/{year}/{month}')->group(function () {
    Route::get('/', 'CalendarController@show')->name('calendar.show')->middleware('auth');
    Route::prefix('/{day}')->group(function () {
        Route::get('events/create', 'EventController@create')->name('events.create');
        Route::post('/events', 'EventController@store')->name('events.store');
        Route::get('/events/{id}', 'EventController@show')->name('events.show');
        Route::get('/events/{id}/edit', 'EventController@edit')->name('events.edit');
        Route::post('/events/{id}', 'EventController@update')->name('events.update');
        Route::delete('/events/{id}', 'EventController@destroy')->name('events.destroy');
    });
});

// '/' にアクセスした時に今月の月のカレンダーにリダイレクト
Route::get('/', function () {
    return redirect()->route('calendar.show', ['year' => Carbon::now()->year, 'month' => Carbon::now()->month]);
});
