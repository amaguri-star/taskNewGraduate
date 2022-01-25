<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Datetime;
use Illuminate\Http\Request;
use Yasumi\Yasumi;

class CalendarController extends Controller
{
    public function show(Request $request, $year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);
        // 今月
        $date = new Carbon($dateStr);

        // 前月
        $prevMonth = $date->copy()->subMonth();

        // 来月
        $nextMonth = $date->copy()->addMonth();

        // 今日
        $current = Carbon::now();

        // 月の日数
        $daysInMonth = $date->daysInMonth;

        // 先月末の空白日数
        $prevDays = ($date->dayOfWeek + 6) % 7;

        // 来月初めの空白日数
        $nextDays = (7 - $date->copy()->endOfMonth()->dayOfWeek) % 7;

        // カレンダー全体の日数
        $count = $prevDays + $daysInMonth + $nextDays;

        // カレンダー開始日
        $startDay = $date->copy()->subDay($prevDays);

        // 日時を格納する変数
        $dates = [];

        //１年間の日本の祝日を取得
        $holidays = Yasumi::create('Japan', $date->year, 'ja_JP');

        // 今月の祝日を取得
        $holidaysInBetween = $holidays->between(
            new DateTime($date->month . '/' . $date->day . '/' . $date->year),
            new DateTime($date->month . '/' . $daysInMonth . '/' . $date->year));

        // 祝日の日付をKey, 祝日名をValueに持つ変数
        $holidaysDate = [];

        // ループで回して一つづつ取り出す
        foreach ($holidaysInBetween as $holiday) {
            $holidaysDate[strval($holiday)] = $holiday->getName();
        }

        // ユーザーのイベントを取得
        $events = $request->user()->events;
        
        // ループで回して一つづつ取り出す
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
        ]);
    }
}
