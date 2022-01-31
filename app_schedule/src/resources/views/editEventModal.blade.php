<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">イベントを編集</h5>
                <button type="button" class="btn-close" onclick="closeEditModal()"></button>
            </div>
            <form id="editEventModalForm" class="modal-body">
                <input type="hidden" name="id" id="event-id">
                <input type="date" name="date" class="modal-input-date" readonly>
                <input type="text" name="title" class="modal-input-title form-control">
            </form>
            <div class="modal-footer">
                <button type="button" class="close-edit-modal btn btn-secondary" onclick="closeEditModal()">閉じる</button>
                <button type="button" class="submit-edit-event btn btn-primary"
                    onclick="editCalendarEvent()">編集</button>
            </div>
        </div>
    </div>
</div>
