<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">イベントを作成</h5>
                <button type="button" class="btn-close" onclick="closeCreateModal()"></button>
            </div>
            <form id="createEventModalForm" class="modal-body">
                <input type="date" name="date" class="modal-input-date" readonly>
                <input type="text" name="title" class="modal-input-title form-control">
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">閉じる</button>
                <button type="button" class="btn btn-primary" onclick="createCalendarEvent()">登録</button>
            </div>
        </div>
    </div>
</div>
