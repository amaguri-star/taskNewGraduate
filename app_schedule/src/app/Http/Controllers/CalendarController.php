<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class CalendarController extends Controller
{
    public function show($year, $month)
    {
        $dateStr = sprintf('%04d-%02d-01', $year, $month);

        // 今月
        $date = new Carbon($dateStr);

        // 前月
        $prevMonth = $date->copy()->subMonth();

        // 来月
        $nextMonth = $date->copy()->addMonth();

        // 今日
        $currentDate = Carbon::now();

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

        for ($i = 0; $i < $count; $i++, $startDay->addDay()) {
            // copyしないと全部同じオブジェクトを入れてしまうことになる
            $dates[] = $startDay->copy();
        }

        return view('calendar', [
            'dates' => $dates,
            'currentDate' => $currentDate,
            'thisDate' => $date,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth]);
    }
}
