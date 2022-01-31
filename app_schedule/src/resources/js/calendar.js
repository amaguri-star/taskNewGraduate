const createModal = document.getElementById('createEventModal');
const editModal = document.getElementById('editEventModal');

const eventValidate = {
    rules: {
        title: {
            required: true
        },
    },
    messages: {
        title: {
            required: 'このフィールドは必須です'
        }
    }
};

window.createCalendarEvent = function createCalendarEvent() {
    let title = createModal.querySelector('.modal-input-title').value;
    let date = createModal.querySelector('.modal-input-date').value;

    $("#createEventModalForm").validate(eventValidate);

    if (!$('#createEventModalForm').valid()) {
        return false;
    }

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
        const btn = `<div id="event_li_${res.id}" class="event_li"><button class="edit_event_bt" onclick="openEditModal('${res.date}', '${res.id}', '${res.title}')">${res.title}</button></div>`
        $(`#event_ul_${res.date}`).append(btn);
    }).fail((err) => {
        console.log(err);
    });

    closeCreateModal();
}

window.editCalendarEvent = function editCalendarEvent() {
    let title = editModal.querySelector('.modal-input-title').value;
    let date = editModal.querySelector('.modal-input-date').value;
    let id = editModal.querySelector('#event-id').value;
    let event = document.querySelector(`#event_li_${id}`);

    $("#editEventModalForm").validate(eventValidate);

    if (!$('#editEventModalForm').valid()) {
        return false;
    }

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
        const btn = `<button class="edit_event_bt" onclick="openEditModal('${res.date}', '${res.id}', '${res.title}')">${res.title}</button>`;
        event.innerHTML = btn;
    }).fail((err) => {
        console.log(err);
    });

    closeEditModal();
}

window.openCreateModal = function openCreateModal(date) {
    createModal.querySelector('.modal-input-date').value = date;
    $(createModal).modal('show');
}

window.openEditModal = function openEditModal(date, id, title) {
    editModal.querySelector('.modal-input-date').value = date;
    editModal.querySelector('.modal-input-title').value = title;
    editModal.querySelector('#event-id').value = id;
    $(editModal).modal('show');
}

function removeLavelIfExists(modal) {
    let label = modal.querySelector('label')
    !!label ? label.remove() : '';
}

window.closeCreateModal = function closeCreateModal() {
    createModal.querySelector('.modal-input-title').value = '';
    removeLavelIfExists(createModal)
    $(createModal).modal('hide');
}

window.closeEditModal = function closeEditModal() {
    removeLavelIfExists(editModal);
    $(editModal).modal('hide');
}