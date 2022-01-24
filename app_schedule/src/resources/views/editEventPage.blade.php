@extends('layouts.app')

@section('title', 'スケジュール編集')

@section('content')
    <div class="container">
        <div class="card w-50 mx-auto">
            <div class="card-body">
                <h5 class="card-title h5">{{ $event->event_date }}</h5>
                <form action="{{ route('events.update', ['event' => $event]) }}" method="POST">
                    @csrf
                    <div class="form-outline my-3">
                        <input type="hidden" name="event_date" value="{{ $event->event_date }}">
                        <input type="text" name="title" id="eventForm" class="form-control"
                        value="{{ $event->title }}" />
                    </div>
                    <button type="submit" class="btn btn-primary">編集</button>
                </form>
            </div>
        </div>
    </div>
@endsection
