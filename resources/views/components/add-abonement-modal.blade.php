<div class="modal fade" id="addAbonement" tabindex="-1" aria-labelledby="addAbonementLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" id="add-abonement">
            @csrf
            <input type="hidden" name="balance" value="{{-$abonementCost}}">
            <div class="modal-header">
                <h5 class="modal-title" id="addAbonementLabel"  data-userid=""></h5>
            </div>
            <div class="modal-body">
                С баланса пользователя будет списано {{$abonementCost}}. Открываем?
            </div>
            <div class="modal-footer">
                <div class="btn btn-secondary" data-bs-dismiss="modal">Отмена</div>
                <button class="btn btn-primary" data-bs-dismiss="modal">Да, открываем</button>
            </div>
        </form>
    </div>
</div>
