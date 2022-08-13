<div class="modal fade" id="addBalance" tabindex="-1" aria-labelledby="addBalanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="" id="update-balance">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addBalanceLabel" data-userid=""></h5>
            </div>
            <div class="modal-body">
                Введите сумму пополнения
                <input type="number" class="form-control" name="balance" id="balance-input" required>
            </div>
            <div class="modal-footer">
                <div class="btn btn-secondary" data-bs-dismiss="modal">Отменить</div>
                <button class="btn btn-primary" data-bs-dismiss="modal">Добавить</button>
            </div>
        </form>
    </div>
</div>
