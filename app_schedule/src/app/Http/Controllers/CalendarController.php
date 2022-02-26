<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Datetime;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Yasumi\Yasumi;

/**
 * カレンダー操作用のコントローラークラス
 * 
 */
class CalendarController extends Controller
{
    /**
     * カレンダー表示用メソッド
     * 
     * 指定された月をカレンダー形式で表示
     * また、ユーザーのイベント情報を取得し、イベントに登録されている日にちごとに表示
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response calendarBladeを表示
     */
    public function show(Request $request)
    {
        // 取得した日時情報（YYYY-MM形式）をもとにCarbonをインスタンス化、$date変数に格納
        $date = new Carbon($request->date);

        // $dateの日付のちょうど１ヶ月後の日付を取得、$prevMonthに格納
        $prevMonth = $date->copy()->subMonth();

        // $dateの日付のちょうど１ヶ月前の日付を取得、$nextMonthに格納
        $nextMonth = $date->copy()->addMonth();

        // 現在時刻を取得、$currentに格納
        $current = Carbon::now();

        // $dateの月の日数を取得,
        $daysInMonth = $date->daysInMonth;

        // 月初めの週の余白日数を取得
        $prevDays = ($date->dayOfWeek + 6) % 7;

        // 月最後の週の余白日数を取得
        $nextDays = (7 - $date->copy()->endOfMonth()->dayOfWeek) % 7;

        // 余白日数と月の日数を足した数を$countに格納
        $count = $prevDays + $daysInMonth + $nextDays;

        // $dateから$prevDays分前の日付を取得
        $startDay = $date->copy()->subDay($prevDays);

        // bladeで使用される配列
        $dates = [];

        // Yasumiライブラリから1年間の日本の休日情報を取得、$holidaysに格納
        $holidays = Yasumi::create('Japan', $date->year, 'ja_JP');

        // $hodaliysから$dateの月の休日情報を取得、$holidaysInBetweenに格納
        $holidaysInBetween = $holidays->between(
            new DateTime($date->month . '/' . $date->day . '/' . $date->year),
            new DateTime($date->month . '/' . $daysInMonth . '/' . $date->year));

        // bladeで使用される休日配列
        $holidaysDate = [];
        

        // keyに休日の日付、valueに休日名を持つ連想配列を生成
        foreach ($holidaysInBetween as $holiday) {
            $holidaysDate[strval($holiday)] = $holiday->getName();
        }

        // ユーザーが持つイベントを全て取得、$eventsに格納
        $events = $request->user()->events;

        // GoogleClientを取得、$clientに格納
        $client = $this->getClient();

        // サービスオブジェクトを構築、$serviceに格納
        $service = new Google_Service_Calendar($client);

        // google_calendar_id環境変数を取得、$calendarIdに格納
        $calendarId = env('GOOGLE_CALENDAR_ID');

        // google_calendarからイベントを取得、$eventsOnGoogleに格納
        $eventsOnGoogle = $service->events->listEvents($calendarId)->getItems();

        // 余白日を含めた１ヶ月分の日付情報をそれぞれ取得し、$datesに格納
        for ($i = 0; $i < $count; $i++, $startDay->addDay()) {
            $dates[] = $startDay->copy();
        }

        // calendarBladeを返す
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

    /**
     * GoogleClient取得、設定用メソッド
     * 
     * Google_Clientをインスタンス化
     * credentialの情報をもとに$clientを取得し返す
     * 
     * @return Google\Client
     */
    private function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API plus Laravel');
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig(storage_path('app/api-key/credential.json'));
        return $client;
    }
}
