@extends('layouts.index')

@section('content')
    <div class="col-xl-8 text-start m-auto">
        <a href="/school">Список школ</a>
        \
        <a href="/school/{{$school->id}}">{{$school->name}}</a>
        \
        {{$group->name}}
    </div>
    <div class="d-flex justify-content-start m-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKaratekaToGroup">
            Добавить спорстменов в группу
        </button>
        <div class="ms-5 d-flex justify-content-between col-xl-7 flex-wrap">
            <h4>{{$group->formatedSchedule}}</h4>
            <input type="date" class="form-control-sm" value="{{$_GET['for_date'] ?? date("Y-m-d")}}" id="visit-date">
            <input type="hidden" name="coach_id" value="{{$profile->coach_id ?? 1}}" id="coach_id">
            <h3>Тренер: {{$group->coach->surname}} {{$group->coach->name}} {{$group->coach->patronymic}}</h3>
            <button type="button" class="btn btn-light ms-2" id="groupOnPause">Приостановить все</button>
            <button type="button" class="btn btn-light ms-2" id="groupUnpause">Снять с паузы все абонементы</button>
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
                @if(isset($user->ticket->is_closed) AND $user->ticket->is_closed == 0)
                    <span class="d-none">{{$closed = false}}</span>
                @else
                    <span class="d-none">{{$closed = true}}</span>
                @endif
                <tr class="text-center @if((int)$user->balance < 0) bg-secondary @elseif($closed) bg-info @endif" id="trUserId={{$user->id}}">
                    <td>
                        <button type="button" class="btn btn-close" data-bs-toggle="modal"
                                data-bs-target="#removeFromGroup"
                                onclick="addDataToModal('{{$user->id}}', 'remove')">
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
                                <a href="/balance/{{$user->id}}/addPaymentForTicket/{{$group->id}}"
                                   class="text-decoration-none text-black">
                                    Оплатить
                                </a>
                            </button>
                        @endif
                    </td>
                    <td id="count-{{$user->id}}-{{$user->ticket->id ?? 0}}">{{$user->ticket?->visitsNumber ?? 0}}</td>
                    <td class="text-center" id="ticketDateid={{$user->id}}">
                        <span id="ticketIsOpen{{$user->id}}" class="@if($closed) d-none @endif">{{$user->ticket?->end_date}}</span>
                        <span id="ticketIsClosed{{$user->id}}" class="@if(!$closed) d-none @endif">Нет абонемента</span>
                    </td>
                    <td>
                        <a href="/balance/{{$user->id}}/new-ticket/{{$group->id}}" id="newTicket{{$user->id}}"
                           class="@if(!$closed) d-none @endif text-decoration-none text-white">
                            <button class="btn btn-primary">
                                +
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('visit-date').addEventListener('change', (e)=>{
            location.search = "?for_date=" + e.target.value
        })
        document.getElementById('groupOnPause').addEventListener('click', ()=>{
            let id   = {{$group->id}};
            let date = document.getElementById('visit-date').value
            let confirmation = confirm("Поставить все абонементы в группе на паузу c "+date+"?");
            if(confirmation){
                groupOnPause(id, date)
            }
        })
        document.getElementById('groupUnpause').addEventListener('click', ()=>{
            let id   = {{$group->id}};
            let confirmation = confirm("Снять с паузы все абонементы в группе?");
            if(confirmation){
                groupUnpause(id)
            }
        })
    </script>
    <x-remove-from-group-modal groupId="{{$group->id}}"/>
    <x-add-karateka-to-group-modal groupId="{{$group->id}}"/>
@endsection
