@extends('layouts.index')

@section('content')
    <div class="d-flex justify-content-center align-items-center flex-column">
        <div>
            <div class="col-xl-12 d-flex justify-content-center m-3" id="shown-balance">
                <h4 class="m-2">Баланс: {{$profile->balance}}</h4>
                <button class="btn btn-dark" id="shown-balance-button">Изменить</button>
            </div>
            <form action="/balance/{{$profile->id}}/update-balance" method="POST" id="edit-balance"
                  class="col-xl-12 d-flex justify-content-center m-3 d-none">
                @csrf
                <h4 class="m-2">Добавить/Списать: <input type="number" name="amount" value="0"></h4>
                <button class="btn btn-dark" id="edit-balance-button">Сохранить</button>
            </form>
            <script>
                document.getElementById('shown-balance-button').addEventListener('click', () => {
                    document.getElementById('shown-balance').classList.add('d-none')
                    document.getElementById('edit-balance').classList.remove('d-none')
                })
                document.getElementById('edit-balance-button').addEventListener('click', () => {
                    document.getElementById('edit-balance').classList.add('d-none')
                    document.getElementById('shown-balance').classList.remove('d-none')
                })
            </script>
        </div>
        <form action="/karateki/{{$profile->id}}" method="POST" class="card col-8">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="card-header d-flex justify-content-between">
                <h3 class="">Редактировать ученика</h3>
                <button class="btn btn-danger">
                    <a href="/balance/{{$profile->id}}/delete-profile" class="text-decoration-none text-white">
                        Удалить
                    </a>
                </button>
            </div>
            <div class="card-body">
                <label for="surname"><b>Введите фамилию</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="surname" placeholder="Введите фамилию"
                       autocomplete="off" required
                       value="{{$profile->surname}}">

                <label for="name"><b>Введите имя</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="name" placeholder="Введите имя" autocomplete="off"
                       required
                       value="{{$profile->name}}">

                <label for="name"><b>Выбрать команду</b></label>
                <select name="team_id" class="form-select">
                    <option value="">-</option>
                    @foreach($teams as $team)
                        <option value="{{$team['id']}}" @if($profile->team_id == $team['id']) selected @endif>
                            {{$team['name'] ?? $team['team_number']}}
                        </option>
                    @endforeach
                </select>

                <label class="mt-3" for="coach_id">
                    <b>Выберите тренера</b><span class="text-danger"> *</span>
                </label>
                <select name="coach_id" class="form-select">
                    @foreach($coaches as $coach)
                        <option value="{{$coach->id}}">
                            {{$coach->surname}} {{$coach->name}} {{$coach->patronymic}}
                        </option>
                    @endforeach
                </select>
                <div>
                    <div class="form-select mt-2" onclick="hideShowAdvancedBlock()"><b>Дополнительные параметры</b>
                    </div>
                    <div class="form-control d-none" id="advanced-block">
                        <label for="patronymic">Введите отчество</label>
                        <input type="text" class="form-control mb-3" name="patronymic"
                               placeholder="Введите отчество" autocomplete="off" value="{{$profile->patronymic}}">
                        <label for="birthday">Дата рождения</label>
                        <input type="date" value="{{$profile->birthday}}" name="birthday" class="form-control mb-2">
                        <label for="weight">Вес</label>
                        <input type="text" value="{{$profile->weight}}" name="weight" class="form-control mb-2"
                               placeholder="000,00">
                        {{--                        <label for="contacts[phone]">Телефон</label>--}}
                        {{--                        <input type="tel" value="{{old('contacts[phone]')}}" name="contacts[phone]" class="form-control" placeholder="+7 ___-___-__-__">--}}
                        <label for="qu">Кю</label>
                        <select name="qu" id="qu" class="form-select col-2">
                            <option value="">-</option>
                            @foreach($qus as $qu)
                                <option value="{{$qu}}" @if($qu == $profile->qu) selected @endif>{{$qu}}</option>
                            @endforeach
                        </select>
                        <label for="dan">Дан</label>
                        <select name="dan" id="dan" class="form-select col-2">
                            <option value="">-</option>
                            @foreach($dans as $dan)
                                <option value="{{$dan}}" @if($dan == $profile->dan) selected @endif>{{$dan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn btn-secondary me-3">
                    <a href="{{ URL::previous() }}" class="text-decoration-none text-white">Отмена</a>
                </div>
                <button class="btn btn-primary me-3">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
    <script>
        function hideShowAdvancedBlock() {
            let target = document.getElementById("advanced-block").className
            if (target === "form-control") {
                document.getElementById("advanced-block").className = "form-control d-none"
            } else {
                document.getElementById("advanced-block").className = "form-control"
            }
        }
    </script>
@endsection
