@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="calendarHeader">
            <h1 class="dateTitle">{{ $thisDate->year }}-{{ $thisDate->month }}</h1>
            <div class="monthButton">
                <button type="button" class="btn btn-primary prevMonthBtn">
                    <a  
                        href="{{ route('calendar.show', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}">先月</a></button>
                <button type="button" class="btn btn-primary nextMonthBtn">
                    <a  
                        href="{{ route('calendar.show', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}">来月</a></button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach (['月', '火', '水', '木', '金', '土', '日'] as $dayOfWeek)
                        <th>{{ $dayOfWeek }}</th>
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
                            class="day {{ $date->toDateString() == $currentDate->toDateString() ? 'currentDate' : '' }} {{ $date->isSaturday() ? 'saturday' : '' }} {{ $date->isSunday() ? 'sunday' : '' }} {{ $date->month != $thisDate->month ? 'otherMonth' : '' }} ">
                            {{ $date->day }}</td>
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
