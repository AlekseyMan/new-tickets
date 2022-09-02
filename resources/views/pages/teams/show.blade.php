@extends('layouts.index')

@section('content')
    <div class="col-6 m-auto mt-3">
        <h3 class="text-center">Команды</h3>
        <table class="table table-vcenter">
            <thead>
            <tr>
                <th class="col-1"></th>
                <th class="col-2">Номер команды</th>
                <th class="col-4">Название команды</th>
                <th class="col-4 text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teams as $team)
                <tr>
                    <td>
                        <form action="/teams/{{$team->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btm btn-close"></button>
                        </form>
                    </td>
                    <form action="/teams/{{$team->id}}" method="POST">
                        <td class="">
                            <input type="number" class="form-control d-none" name="team_number"
                                   value="{{$team->team_number}}" id="input-number-{{$team->id}}">
                            <span id="text-number-{{$team->id}}">{{$team->team_number}}</span>
                        </td>
                        <td class="">
                            <input type="text" class="form-control d-none" name="name" value="{{$team->name}}"
                                   id="input-name-{{$team->id}}">
                            <span id="text-name-{{$team->id}}">{{$team->name}}</span>
                        </td>
                        <td class="d-flex">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <button class="btn btn-success ms-2 me-2 d-none" id="button-save-{{$team->id}}">Сохранить
                            </button>
                            <div class="btn btn-danger ms-2 me-2 d-none" id="button-cancel-{{$team->id}}">Отменить</div>
                            <div class="btn btn-primary ms-2 me-2" id="button-edit-{{$team->id}}"
                                 onclick="teamEdit({{$team->id}})">Редактировать
                            </div>
                        </td>
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form class="mt-5" action="/teams" method="POST">
            @csrf
            <h3 class="text-center">Добавить команду</h3>
            <table class="table table-vcenter">
                <thead>
                <tr>
                    <th class="col-2">Номер команды</th>
                    <th class="col-4">Название команды</th>
                    <th class="col-4 text-center"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="number" class="form-control" name="team_number" required>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="name" required>
                    </td>
                    <td>
                        <button class="btn btn-success">Добавить</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection

