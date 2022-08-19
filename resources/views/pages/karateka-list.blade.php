@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addKarateka">Добавить
                спортсмена
            </button>
        </div>
        <table
            class="table table-vcenter">
            <thead>
            <tr>
                <th class="col-xl-3 text-center">Фамилия Имя</th>
                <th class="col-xl-2 text-center">Дата рождения</th>
                <th class="col-xl-1 text-center">Кю</th>
                <th class="col-xl-1 text-center">Вес</th>
                @auth('sanctum')
                    <th class="col-xl-1">Редактировать</th>
                    <th class="col-xl-1">Удалить</th>
                @endauth
            </tr>
            </thead>
            <tbody id="tbody">
            @isset($karateki)
                @foreach($karateki as $user)
                    <tr class="col-xl-3 text-center">
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
                        @auth('sanctum')
                            <td class="text-muted">
                                Edit
                            </td>
                            <td class="text-muted">Delete</td>
                        @endauth
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
    </div>
    <x-add-karateka-modal/>
@endsection
