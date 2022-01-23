@extends('layouts.app')

@section('title', 'スケジュール編集')

@section('content')
    <div class="container">
        <div class="card w-50 mx-auto">
            <div class="card-body">
                <h5 class="card-title h5">{{ $date }}</h5>
                <form action="{{ route('events.update') }}" method="POST">
                    @csrf
                    <div class="form-outline my-3">
                        <input type="hidden" name="event_date" value="{{ $date }}">
                        <input type="text" name="title" id="eventForm" class="form-control" />
                        <label class="form-label" for="eventForm">タスクを編集</label>
                        <button type="button" class="btn btn-primary">編集</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
