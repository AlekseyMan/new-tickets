@extends('layouts.index')

@section('content')
    <div class="d-flex justify-content-start">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKaratekaToGroup">
            Добавить спорстмена в группу
        </button>
        <div class="ms-5 d-flex justify-content-between col-xl-7">
            <h4>{{$group->days}} Время: {{$group->time_start}} - {{$group->time_end}}</h4>
            <h3>{{$group->coach->surname}} {{$group->coach->name}} {{$group->coach->patronymic}}</h3>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter" id="token" data-token="{{ csrf_token() }}">
            <thead>
            <tr class="text-center">
                <th class="col-xl-1"></th>
                <th class="col-xl-3">Спортсмен</th>
                <th class="col-xl-2">Посещение</th>
                <th class="col-xl-2">Пропуск</th>
                <th class="col-xl-2">Баланс</th>
                <th class="col-xl-1">Занятия</th>
                <th class="col-xl-2">Окончание</th>
                <th class="col-xl-1"></th>
            </tr>
            </thead>
            <tbody id="tbody">
            @foreach($groupUsers as $user)
                <tr class="text-center" id="trUserId={{$user->id}}">
                    <td>
                        <button type="button" class="btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeFromGroup"
                                onclick="addDataToModal('{{$user->id}}', 'remove')">X
                        </button>
                    </td>
                    <td class="@if($user->balance < 0) bg-danger @endif" id="userNameId={{$user->id}}">
                        <a href="/karateki/{{$user->id}}" class="text-white text-decoration-none">
                            {{$user->surname}} {{$user->name}}
                        </a>
                    </td>
                    <td>
                        <button data-ticketid="{{$user->ticket->id ?? 0}}"
                                class="btn @isset($user->ticket->visit) btn-success @endisset"
                                onclick="markVisit('visit-{{$user->id}}-{{$user->ticket->id ?? 0}}')"
                                id="visit-{{$user->id}}-{{$user->ticket->id ?? 0}}">
                            Посетил
                        </button>
                    </td>
                    <td>
                        <button data-ticketid="{{$user->ticket->id ?? 0}}"
                                class="btn @isset($user->ticket->miss) btn-danger @endisset"
                                onclick="markVisit('miss-{{$user->id}}-{{$user->ticket->id ?? 0}}')"
                                id="miss-{{$user->id}}-{{$user->ticket->id ?? 0}}">
                            Пропустил
                        </button>
                    </td>
                    <td class="@if($user->balance >= 0) bg-success @else bg-danger @endif"
                        id="userBalanceId={{$user->id}}">
                        <b id="userId={{$user->id}}">{{$user->balance}}</b>
                        <button type="button" class="btn btn-light ms-2" data-bs-toggle="modal"
                                data-bs-target="#addBalance"
                                onclick="addDataToModal('{{$user->id}}', 'balance')">+
                        </button>
                    </td>
                    <td id="count-{{$user->id}}-{{$user->ticket->id ?? 0}}">{{$user->ticket->visits_number ?? 0}}</td>
                    <td class="text-center"
                        id="ticketDateid={{$user->id}}">{{$user->ticket->end_date ?? 'Нет абонемента'}}</td>
                    <td>@isset($user->ticket->end_date)
                        @else
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAbonement"
                                    id="button-{{$user->id}}-{{$user->ticket->id ?? 0}}"
                                    onclick="addDataToModal('{{$user->id}}', 'abonement')">+
                            </button>
                        @endisset</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-remove-from-group-modal/>
    <x-add-karateka-to-group-modal karateki="{{$karateki}}"/>
    <x-add-balance-modal/>
    <x-add-abonement-modal settings="{{$settings}}"/>
@endsection
