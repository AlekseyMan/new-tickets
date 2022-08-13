@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <button type="button" class="btn btn-success">
                <a href="/karateki/create" class="text-decoration-none text-white">Добавить спортсмена</a>
            </button>
        </div>
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
                            <a href="/karateki/{{$user->id}}" class="text-dark text-decoration-none">
                                <h3>{{$user->surname. " " . $user->name}}</h3>
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
@endsection
