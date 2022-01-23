@extends('layouts.app')

@section('title', 'スケジュール登録')

@section('content')
    <div class="container">
        <div class="card w-50 mx-auto">
            <div class="card-body">
              <h5 class="card-title h5">{{ $date }}</h5>
              <div class="form-outline my-3">
                <input type="hidden" name="event_date" value="{{ $date }}">
                <input type="text" name="title" id="eventForm" class="form-control"/>
                <label class="form-label" for="eventForm">タスクを登録</label>
              </div>
              <button type="button" class="btn btn-primary">登録</button>
            </div>
          </div>
    </div>
@endsection