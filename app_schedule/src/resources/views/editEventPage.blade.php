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
                        <input type="text" name="title" id="eventForm" class="form-control"
                            value="{{ $event->title }}" />
                    </div>
                    <button type="submit" class="btn btn-primary">編集</button>
                    <button type="submit" class="btn btn-danger" form="deleteForm"
                        onclick="return confirm('本当に削除しますか?');">削除</button>
                </form>
                <form action="{{ route('events.destroy', ['event' => $event]) }}" id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endsection
