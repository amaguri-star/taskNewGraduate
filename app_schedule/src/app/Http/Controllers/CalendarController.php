<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class CalendarController extends Controller
{
    public function show()
    {
        $dateStr = sprintf('%04d-%02d-01', 2022, 1);
        $date = new Carbon($dateStr);

        // 今日
        $currentDate = Carbon::now();

        // 月の日数
        $daysInMonth = $date->daysInMonth;

        // 先月末の空白日数
        $prevDays = $date->dayOfWeek;

        // 来月初めの空白日数
        $nextDays = 6 - $date->copy()->endOfMonth()->dayOfWeek;

        // カレンダー全体の日数
        $count = $prevDays + $daysInMonth + $nextDays;

        // カレンダー開始日
        $startDay = $date->copy()->subDay($prevDays);

        // 日時を格納する変数
        $dates = [];

        for ($i = 0; $i < $count; $i++, $startDay->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $startDay->copy();
        }

        return view('calendar', ['dates' => $dates, 'currentDate' => $currentDate]);
    }
}
