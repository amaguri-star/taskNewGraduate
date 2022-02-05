<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/calendar', 'CalendarController@show')->name('calendar.show')->middleware('auth');
Route::get('/events/create', 'EventController@create')->name('events.create');
Route::post('/events', 'EventController@store')->name('events.store');
Route::get('/events/{event}/edit', 'EventController@edit')->name('events.edit');
Route::post('/events/{event}', 'EventController@update')->name('events.update');
Route::delete('/events/{event}', 'EventController@destroy')->name('events.destroy');

Route::get('/', function () {
    return redirect()->route('calendar.show', ['date' => Carbon::now()->isoformat('YYYY-MM')]);
});
