@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <a href="/karateki/create" class="text-decoration-none text-white">
                <button type="button" class="btn btn-success">
                    Добавить спортсмена
                </button>
            </a>
            <a href="/teams" class="text-decoration-none text-white">
                <button type="button" class="btn btn-primary ms-3">
                    Распределить по командам
                </button>
            </a>
        </div>
        <button class="btn btn-info" id="filter">
            Фильтр
        </button>
        <form method="GET" action="/karateki">
            <div class="@if(empty($_GET)) d-none @endif d-flex justify-content-start mt-3 mb-3 border-top border-bottom" id="search-block">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <button class="btn btn-success m-2">Применить фильтр</button>
                    <a href="/karateki" class="text-white text-decoration-none">
                        <div class="btn btn-primary m-2">
                            Сбросить фильтр
                        </div>
                    </a>
                </div>
                <div class="col-3 border-start ps-2 ms-2">
                    <h4>Выбор по тренеру</h4>
                    <select name="coach_id" id="coaches" class="form-select mb-2">
                        @foreach($coaches as $coach)
                            <option value="{{$coach->id}}" @if($_GET['coach_id'] === $coach->id) selected @elseif(\Illuminate\Support\Facades\Auth::user()->profile->id === $coach->id) selected @endif>{{$coach->fullName}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 border-start ps-2 ms-2">
                    <h4>Выбор по командам</h4>
                    <select name="team_id" id="coaches" class="form-select mb-2">
                        <option value="">-</option>
                        @foreach($teams as $team)
                            <option value="{{$team->id}}" @if($_GET['team_id'] === $team->id) selected @endif>{{$team->name ?? $team->number}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <table class="table table-vcenter">
            <thead>
            <tr>
                <th class="col-3 text-center">Фамилия Имя</th>
                <th class="col-2 text-center">Дата рождения</th>
                <th class="col-1 text-center">Кю</th>
                <th class="col-1 text-center">Вес</th>
                <th class="col-1">Редактировать</th>
            </tr>
            </thead>
            <tbody id="tbody">
            @isset($karateki)
                @foreach($karateki as $user)
                    <tr class="text-center">
                        <td
                            @isset($user->ticket)
                                class="@if($user->ticket->paused === 1) bg-blue @else bg-success @endif"
                            @endisset
                        >
                            <a href="/profile/{{$user->id}}/ticket" class="text-dark text-decoration-none">
                                <h3>{{$user->fullName}}</h3>
                            </a>
                        </td>
                        <td>{{$user->birthday}}</td>
                        <td>{{$user->qu}}</td>
                        <td>{{$user->weight}}</td>
                        <td class="text-muted">
                            <form action="/karateki/{{$user->id}}/edit" method="GET">
                                <button class="btn btn-primary">Редактировать</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('filter').addEventListener('click', () => {
            if (document.getElementById('search-block').className.includes('d-none')) {
                document.getElementById('search-block').classList.remove('d-none')
            } else {
                document.getElementById('search-block').classList.add('d-none')
            }
        })
    </script>
@endsection
