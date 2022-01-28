<form id="ex-{{ $dateStr }}" class="modal w-50 h-50 m-auto">
    <p>{{ $dateStr }}</p>
    <a href="#" rel="modal:close">Close</a>
</form>
<a href="#ex-{{ $dateStr }}" rel="modal:open">
    {{ $date->day }}
    <span>
        {{ $isHoliday ? $holidays[$dateStr] : '' }}
    </span>
</a>
