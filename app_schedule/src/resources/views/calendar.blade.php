@extends('layouts.app')

@section('title')Calendar {{ $thisDate->year }}-{{ $thisDate->month }}@endsection

@section('content')
    <div class="container">
        <div class="calendarHeader d-flex p-2">
            <h3 class="dateTitle h3">{{ $thisDate->year }}-{{ $thisDate->month }}</h3>
            <div class="ms-auto d-flex">
                <a class="d-block btn btn-primary shadow-sm"
                    href="{{ route('calendar.show', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}">先月</a>
                <a class="d-block btn btn-primary shadow-sm ms-3"
                    href="{{ route('calendar.show', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}">来月</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach (['月', '火', '水', '木', '金', '土', '日'] as $dayOfWeek)
                        <th class="text-center">{{ $dayOfWeek }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dates as $date)
                    @if ($date->dayOfWeek == 1)
                        <tr>
                    @endif

                    @if ($date->month == $thisDate->month)
                        <td
                            class="p-0 day
                             {{ $date->toDateString() == $currentDate->toDateString() ? 'bg-warning bg-gradient' : '' }} 
                             {{ $date->isSaturday() ? 'text-primary' : '' }}
                             {{ $date->isSunday() ? 'text-danger' : '' }} 
                             {{ array_key_exists($date->toDateString(), $holidaysDate) ? 'text-success' : '' }}">
                            <a class="d-block w-100 h-100"
                                href="{{ route('events.create', ['year' => $date->year, 'month' => $date->month, 'day' => $date->day]) }}">
                                {{ $date->day }}
                                <span>
                                    {{ array_key_exists($date->toDateString(), $holidaysDate) ? $holidaysDate[$date->toDateString()] : '' }}
                                </span>
                            </a>
                        </td>
                    @else
                        <td class="day"></td>
                    @endif

                    @if ($date->dayOfWeek == 0)
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
