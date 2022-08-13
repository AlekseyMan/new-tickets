<div class="modal fade" id="addKaratekaToGroup" tabindex="-1" aria-labelledby="addKaratekaToGroupLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form action="/group/{{$group->id}}/add-karateki-to-group" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addKaratekaToGroupLabel">Добавить </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Добавить в группу:
                <select name="ids[]" id="selectKarateka" class="form-select" multiple
                        aria-label="multiple select example">
                    <option disabled selected value="0">Выберите спорстмена</option>
                    @foreach($karateki as $user)
                        {{$show = true}}
                        @foreach($group->karateki as $groupUser)
                            @if($groupUser->id === $user->id)
                                {{$show = false}}
                            @endif
                        @endforeach
                        @if($show)
                            <option value="{{$user->id}}">{{$user->surname}} {{$user->name}}</option>
                        @endif
                    @endforeach
                </select>
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

