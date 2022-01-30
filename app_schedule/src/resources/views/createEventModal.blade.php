<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">イベントを作成 <span class="modal-date"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="title" class="modal-title form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                <button onclick="createCalendarEvent()" type="button" class="btn btn-primary">登録</button>
            </div>
        </div>
    </div>
</div>
