function generateEditModal(id, title) {
    const htmlcode =
        `<div>
            <div id="edit-modal-${id}" class="modal w-50 h-50 m-auto">
                <p>${id}</p>
                <input type="text" name="title" id="edit-input-${id}" class="form-control" required>
                <button onclick="editEventCalendar(event, ${id})">編集</button>
                <a href="#" rel="modal:close">Close</a>
            </div>
            <a class="link_event_edit bg-info bg-gradient" href="#edit-modal-${id}" rel="modal:open">
                ${title}
                <span>
                    {{ $isHoliday ? $holidays[$dateStr] : '' }}
                </span>
            </a>
        <div>`
    return htmlcode
}

function createEventCalendar(e, date) {
    let title = document.getElementById(`create-input-${date}`).value;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'events',
        type: 'post',
        dataType: 'json',
        data: {
            event_date: date,
            title: title,
        }
    }).done((res) => {
        $(`#event_list_${date}`).append(generateEditModal(res.id, res.title));

    }).fail((err) => {
        console.log(err);
    });
}

function editEventCalendar(e, id) {
    console.log(e, id)
}
