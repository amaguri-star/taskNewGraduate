<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Datetime;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Yasumi\Yasumi;

class CalendarController extends Controller
{
    public function show(Request $request)
    {
        $date = new Carbon($request->date);
        $prevMonth = $date->copy()->subMonth();
        $nextMonth = $date->copy()->addMonth();
        $current = Carbon::now();
        $daysInMonth = $date->daysInMonth;
        $prevDays = ($date->dayOfWeek + 6) % 7;
        $nextDays = (7 - $date->copy()->endOfMonth()->dayOfWeek) % 7;
        $count = $prevDays + $daysInMonth + $nextDays;
        $startDay = $date->copy()->subDay($prevDays);
        $dates = [];
        $holidays = Yasumi::create('Japan', $date->year, 'ja_JP');
        $holidaysInBetween = $holidays->between(
            new DateTime($date->month . '/' . $date->day . '/' . $date->year),
            new DateTime($date->month . '/' . $daysInMonth . '/' . $date->year));
        $holidaysDate = [];
        foreach ($holidaysInBetween as $holiday) {
            $holidaysDate[strval($holiday)] = $holiday->getName();
        }
        $events = $request->user()->events;
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = env('GOOGLE_CALENDAR_ID');
        $eventsOnGoogle = $service->events->listEvents($calendarId)->getItems();
        for ($i = 0; $i < $count; $i++, $startDay->addDay()) {
            $dates[] = $startDay->copy();
        }
        return view('calendar', [
            'dates' => $dates,
            'current' => $current->toDateString(),
            'thisDate' => $date,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'holidays' => $holidaysDate,
            'events' => $events,
            'eventsOnGoogle' => $eventsOnGoogle,
        ]);
    }

    private function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API plus Laravel');
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig(storage_path('app/api-key/credential.json'));
        return $client;
    }
}
