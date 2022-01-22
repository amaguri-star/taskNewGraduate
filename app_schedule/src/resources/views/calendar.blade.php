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
                        @if (array_key_exists($date->toDateString(), $holidaysDate))
                            <td class="day text-success {{ $date->toDateString() == $currentDate->toDateString() ? 'bg-warning bg-gradient' : '' }}">{{ $date->day }}
                                <span>{{ $holidaysDate[$date->toDateString()] }}</span>
                            </td>
                        @else
                            <td
                                class="day {{ $date->toDateString() == $currentDate->toDateString() ? 'bg-warning bg-gradient' : '' }} {{ $date->isSaturday() ? 'text-primary' : '' }} {{ $date->isSunday() ? 'text-danger' : '' }}">
                                {{ $date->day }}</td>
                        @endif
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
