<form id="ex-edit-{{ $dateStr }}" class="modal w-50 h-50 m-auto">
    <p>{{ $dateStr }} edit</p>
    <input type="text" name="title" value={{ $event->title }}>
    <a href="#" rel="modal:close">Close</a>
</form>
<a class="link_event_edit bg-info bg-gradient" href="#ex-edit-{{ $dateStr }}" rel="modal:open">
    {{ $event->title }}
</a>
