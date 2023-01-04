@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <a href="/teams/show" class="text-decoration-none text-white">
                <button type="button" class="btn btn-primary ms-3">
                    Настроить команды
                </button>
            </a>
            <a href="/teams-list" class="text-decoration-none text-white">
                <button type="button" class="btn btn-primary ms-3">
                    Список
                </button>
            </a>
        </div>
        <button class="btn btn-info" id="filter">
            Фильтр
        </button>
        <form method="GET" action="/teams">
            <div class="@if(empty($_GET)) d-none @endif d-flex justify-content-start mt-3 mb-3 border-top border-bottom"
                 id="search-block">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <button class="btn btn-success m-2">Применить фильтр</button>
                    <a href="/teams" class="text-white text-decoration-none">
                        <div class="btn btn-primary m-2">
                            Сбросить фильтр
                        </div>
                    </a>
                </div>
                <div class="col-3 border-start ps-2 ms-2">
                    <h4>Выбор по тренеру</h4>
                    <select name="coach_id" id="coaches" class="form-select mb-2">
                        @foreach($coaches as $coach)
                            <option value="{{$coach->id}}"@if(isset($_GET['coach_id']) AND $_GET['coach_id'] == $coach->id) selected @elseif(\Illuminate\Support\Facades\Auth::user()->profile->id === $coach->id) selected @endif>{{$coach->fullName}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 border-start ps-2 ms-2">
                    <h4>Выбор по командам</h4>
                    <select name="team_id" id="coaches" class="form-select mb-2">
                        <option value="">-</option>
                        @foreach($teams as $team)
                            <option value="{{$team->id}}" @if(isset($_GET['team_id']) AND $_GET['team_id'] == $team->id) selected @endif>{{$team->name ?? $team->number}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <form method="POST" action="/teams/update-teams">
            @csrf
            <button class="btn btn-success float-end d-none" id="button-save">Сохранить изменения</button>
            <table class="table table-vcenter">
                <thead>
                <tr>
                    <th class="col-3 text-center">Фамилия Имя</th>
                    <th class="text-center">
                        Команды
                    </th>
                </tr>
                </thead>
                <tbody id="tbody">
                @isset($karateki)
                    @foreach($karateki as $user)
                        <tr class="text-start" id="user-{{$user->id}}">
                            <td>
                                <a href="/profile/{{$user->id}}/ticket" class="text-dark text-decoration-none">
                                    <h3>{{$user->fullName}}</h3>
                                </a>
                            </td>

                            <td class="text-start">
                                @foreach($teams as $team)
                                    <input type="checkbox" name="teams[{{$team->id}}][{{$user->id}}]" class="ms-2 form-check-input"
                                    @if($user->team_id == $team->id) checked @endif>
                                    {{$team->name ?? $team->team_number}}
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
        </form>
    </div>
    <script>
        document.getElementById('filter').addEventListener('click', () => {
            if (document.getElementById('search-block').className.includes('d-none')) {
                document.getElementById('search-block').classList.remove('d-none')
            } else {
                document.getElementById('search-block').classList.add('d-none')
            }
        })
        document.getElementById('tbody').addEventListener('change', (e) => {
            if(e.target.nodeName === "INPUT"){
                const targetName = e.target.name
                let inputs = e.target.parentElement.getElementsByTagName('input')
                for(let i = 0; i < inputs.length; i++) {
                    if(inputs[i].name === targetName){
                        inputs[i].checked = true
                    } else {
                        inputs[i].checked = false
                        inputs[i].className = "ms-2 form-check-input bg-white"
                    }
                }
                e.target.classList.add('bg-dark')
                document.getElementById('button-save').classList.remove('d-none')
            }
        })
    </script>
@endsection

