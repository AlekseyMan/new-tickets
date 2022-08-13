<div class="modal fade" id="removeFromGroup" tabindex="-1" aria-labelledby="removeFromGroupLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="/group/{{$groupId}}/remove-from-group">
            @csrf
            <input type="hidden" name="profile_id" id="remove-user-id">
            <div class="modal-header">
                <h5 class="modal-title" id="removeFromGroupLabel">Удалить из группы ?</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <div class="btn btn-secondary" data-bs-dismiss="modal">Отмена</div>
                <button class="btn btn-primary" data-bs-dismiss="modal">Удалить</button>
            </div>
        </form>
    </div>
</div>
