<div class="modal fade" id="addKaratekaToGroup" tabindex="-1" aria-labelledby="addKaratekaToGroupLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/group/{{$group->id}}/add-karateka-to-group" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addKaratekaToGroupLabel">Добавить </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Добавить в группу:
                    <input type="text" name="name" class="form-control" list="karateki"
                           placeholder="Нажмите для выбора спортсмена или начните ввод имени">
                    <datalist id="karateki">
                        @foreach($karateki as $user)
                            {{$show = true}}
                            @foreach($group->karateki as $groupUser)
                                @if($groupUser->id === $user->id)
                                    {{$show = false}}
                                @endif
                            @endforeach
                            @if($show)
                                <option>{{$user->surname}} {{$user->name}}</option>
                            @endif
                        @endforeach
                    </datalist>
                        <option disabled selected value="0">Выберите спорстмена</option>

                    </input>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-secondary" data-bs-dismiss="modal">Отмена</div>
                    <button class="btn btn-primary" data-bs-dismiss="modal">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

