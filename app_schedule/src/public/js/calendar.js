function createCalendarEvent() {
    let modal = document.getElementById('createEventModal');
    let title = modal.querySelector('.modal-input').value;
    let date = modal.querySelector('.modal-date').textContent;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: 'events',
        type: 'post',
        dataType: 'json',
        data: {
            date: date,
            title: title,
        }
    }).done((res) => {
        const btn = `<div id="event_li_${res.id}" class="event_li"><button class="edit_event_bt" onclick="openEditEventModal('${res.date}', '${res.id}', '${res.title}')">${res.title}</button></div>`
        $(`#event_ul_${res.date}`).append(btn);
    }).fail((err) => {
        console.log(err);
    });

    closeModal(modal);
}

function editCalendarEvent() {
    let modal = document.getElementById('editEventModal');
    let title = modal.querySelector('.modal-input').value;
    let date = modal.querySelector('.modal-date').textContent;
    let id = modal.querySelector('#event-id').value;
    let event = document.querySelector(`#event_li_${id}`);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `events/${id}`,
        type: 'post',
        dataType: 'json',
        data: {
            id: id,
            date: date,
            title: title,
        }
    }).done((res) => {
        console.log(event);
        const btn = `<button class="edit_event_bt" onclick="openEditEventModal('${res.date}', '${res.id}', '${res.title}')">${res.title}</button>`;
        event.innerHTML = btn;
    }).fail((err) => {
        console.log(err);
    });

    closeModal(modal);
}

function openCreateEventModal(date) {
    let modalDom = document.getElementById('createEventModal');
    let modalDomDate = modalDom.querySelector('.modal-date');
    modalDomDate.textContent = date;
    let modalInstance = new bootstrap.Modal(modalDom);
    modalInstance.show();
}

function openEditEventModal(date, id, title) {
    let modalDom = document.getElementById('editEventModal');
    let modalDomDate = modalDom.querySelector('.modal-date');
    let modalDomTitle = modalDom.querySelector('.modal-input');
    let modalDomInputForId = modalDom.querySelector('#event-id');
    modalDomDate.textContent = date;
    modalDomTitle.value = title;
    modalDomInputForId.value = id;
    let modalInstance = new bootstrap.Modal(modalDom);
    modalInstance.show();
}

function closeModal(modal) {
    modal.querySelector('.modal-input').value = '';
    bootstrap.Modal.getInstance(modal).hide();
}

