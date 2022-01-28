<div id="edit-modal-{{ $event->id }}" class="modal w-50 h-50 m-auto">
    <p>{{ $dateStr }} edit</p>
    <input type="text" name="title" id="edit-input-{{ $event->id }}" class="form-control" value='{{ $event->title }}' required>
    <button onclick="editEventCalendar(event, '{{ $event->id }}')">編集</button>
    <a href="#" rel="modal:close">Close</a>
</div>

{{-- クリック --}}
<a class="link_event_edit bg-info bg-gradient" href="#edit-modal-{{ $event->id }}" rel="modal:open">
    {{ $event->title }}
</a>
