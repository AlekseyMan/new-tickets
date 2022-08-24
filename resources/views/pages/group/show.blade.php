@extends('layouts.index')

@section('content')
    <div class="d-flex justify-content-start m-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKaratekaToGroup">
            Добавить спорстменов в группу
        </button>
        <div class="ms-5 d-flex justify-content-between col-xl-7">
            <h4>{{$group->formatedSchedule}}</h4>
            <h3>Тренер: {{$group->coach->surname}} {{$group->coach->name}} {{$group->coach->patronymic}}</h3>
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
            @foreach($group->karateki as $user)
                <tr class="text-center @if((int)$user->balance < 0) bg-danger @endif" id="trUserId={{$user->id}}">
                    <td>
                        <button type="button" class="btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeFromGroup"
                                onclick="addDataToModal('{{$user->id}}', 'remove')">X
                        </button>
                    </td>
                    <td class="" id="userNameId={{$user->id}}">
                        <a href="/profile/{{$user->id}}/ticket" class="text-black text-decoration-none">
                            {{$user->fullName}}
                        </a>
                    </td>
                    <td>
                        @if(isset($user->ticket) AND $user->ticket->paused == 1)
                            Абонемент на паузе
                        @else
                            <button data-ticketid="{{$user->ticket->id ?? 0}}"
                                    class="btn @isset($user->ticket->visit) btn-success @endisset"
                                    onclick="markVisit('visit-{{$user->id}}-{{$user->ticket->id ?? 0}}')"
                                    id="visit-{{$user->id}}-{{$user->ticket->id ?? 0}}">
                                Посетил
                            </button>
                        @endif
                    </td>
                    <td>
                        @if(isset($user->ticket) AND $user->ticket->paused == 1)
                            Абонемент на паузе
                        @else
                            <button data-ticketid="{{$user->ticket->id ?? 0}}"
                                    class="btn @isset($user->ticket->miss) btn-danger @endisset"
                                    onclick="markVisit('miss-{{$user->id}}-{{$user->ticket->id ?? 0}}')"
                                    id="miss-{{$user->id}}-{{$user->ticket->id ?? 0}}">
                                Пропустил
                            </button>
                        @endif
                    </td>
                    <td class=""
                        id="userBalanceId={{$user->id}}">
                        <b id="userId={{$user->id}}">{{$user->balance ?? 0}}</b>
                        @if($user->balance < 0)
                            <button type="button" class="btn btn-light ms-2">
                                <a href="/balance/{{$user->id}}/addPaymentForTicket" class="text-decoration-none text-black">
                                    Оплатить
                                </a>
                            </button>
                        @endif
                    </td>
                    <td id="count-{{$user->id}}-{{$user->ticket->id ?? 0}}">{{$user->ticket?->visitsNumber ?? 0}}</td>
                    <td class="text-center" id="ticketDateid={{$user->id}}">
                        @if(isset($user->ticket->is_closed) AND $user->ticket->is_closed == 0)
                            {{$user->ticket?->end_date}}
                        @else
                            Нет абонемента
                        @endif
                    </td>
                    <td>@if(isset($user->ticket->is_closed) AND $user->ticket->is_closed == 0)
                        @else
                            <button class="btn btn-primary">
                                <a href="/balance/{{$user->id}}/new-ticket" class="text-decoration-none text-white">
                                    +
                                </a>
                            </button>
                        @endisset
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-remove-from-group-modal groupId="{{$group->id}}"/>
    <x-add-karateka-to-group-modal groupId="{{$group->id}}"/>
@endsection
