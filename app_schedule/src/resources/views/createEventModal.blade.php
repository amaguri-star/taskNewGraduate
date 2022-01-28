<div id="create-modal-{{ $dateStr }}" class="modal w-50 h-50 m-auto">
    <p>{{ $dateStr }}</p>
    <input type="text" name="title" id="create-input-{{ $dateStr }}" class="form-control" required>
    <button onclick="createEventCalendar(event, '{{ $dateStr }}')">登録</button>
    <a href="#" rel="modal:close">Close</a>
</div>

{{-- クリック --}}
<a href="#create-modal-{{ $dateStr }}" rel="modal:open">
    {{ $date->day }}
    <span>
        {{ $isHoliday ? $holidays[$dateStr] : '' }}
    </span>
</a>
