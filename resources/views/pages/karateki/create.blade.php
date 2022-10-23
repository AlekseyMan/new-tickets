@extends('layouts.index')

@section('content')
    <div class="d-flex justify-content-center">
        <form action="/karateki" method="POST" class="card col-8">
            @csrf
            <div class="card-header">
                <h3 class="">Добавить ученика</h3>
            </div>
            <input type="hidden" name="profile_role" value="{{$role}}">
            <div class="card-body">
                <label for="surname"><b>Введите фамилию</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="surname" placeholder="Введите фамилию" autocomplete="off" required>

                <label for="name"><b>Введите имя</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="name" placeholder="Введите имя" autocomplete="off" required>

                <label for="name"><b>Выбрать команду</b></label>
                <select name="team_id" class="form-select">
                    <option value="">-</option>
                    @foreach($teams as $team)
                        <option value="{{$team->id}}">
                            {{$team->name ?? $team->team_number}}
                        </option>
                    @endforeach
                </select>
                <label class="mt-3" for="coach_id">
                    <b>Выберите тренера</b><span class="text-danger"> *</span>
                </label>
                <select name="coach_id" class="form-select">
                    @foreach($coaches as $coach)
                        <option value="{{$coach->id}}" @if(\Illuminate\Support\Facades\Auth::user()->profile->id === $coach->id) selected @endif>
                            {{$coach->fullName}}
                        </option>
                    @endforeach
                </select>
                <div>
                    <div class="form-select mt-2 cursor-pointer" onclick="hideShowAdvancedBlock()"><b>Дополнительные параметры</b></div>
                    <div class="form-control d-none" id="advanced-block">
                        <label for="patronymic">Введите отчество</label>
                        <input type="text" class="form-control mb-3" name="patronymic" placeholder="Введите отчество" autocomplete="off">
                        <label for="birthday">Дата рождения</label>
                        <input type="date" value="{{old('birthday')}}" name="birthday" class="form-control mb-2">
                        <label for="weight">Вес</label>
                        <input type="text" value="{{old('weight')}}" name="weight" class="form-control mb-2" placeholder="000,00">
{{--                        <label for="contacts[phone]">Телефон</label>--}}
{{--                        <input type="tel" value="{{old('contacts[phone]')}}" name="contacts[phone]" class="form-control" placeholder="+7 ___-___-__-__">--}}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn btn-secondary me-3">
                    <a href="{{ URL::previous() }}" class="text-decoration-none text-white">Отмена</a>
                </div>
                <button class="btn btn-primary me-3">
                    Добавить
                </button>
            </div>
        </form>
    </div>
    <script>
        function hideShowAdvancedBlock(){
            let target = document.getElementById("advanced-block").className
            if(target === "form-control"){
                document.getElementById("advanced-block").className = "form-control d-none"
            } else {
                document.getElementById("advanced-block").className = "form-control"
            }
        }
    </script>
@endsection
