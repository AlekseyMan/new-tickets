@extends('layouts.index')

@section('content')
    <button class="btn btn-dark"><a href="/profile/{{$profile->id}}/ticket" class="text-decoration-none text-white">Вернуться</a></button>
    <form class="table-responsive" action="/profile/{{$profile->id}}/ticket/{{$ticket->id}}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <h2>{{$profile->fullName}}</h2>
        </div>
        <h3 class="text-center">Абонемент №{{$ticket->id}} @if($ticket->is_closed === 1)
                <span class="text-danger">(закрыт)</span>
            @endif</h3>
        <div class="d-flex justify-content-center">
            @if($ticket->paused === 0)
                <p class="text-center text-primary">С {{date("d-m-Y", strtotime($ticket->created_at))}} </p>
                <p class="text-center text-primary">&nbsp; по <input type="date" name="end_date" value="{{$ticket->end_date}}"></p>
            @else
                <p class="text-center text-danger"> Приостановлен с : {{$ticket->pause_date}}</p>
            @endif
        </div>
        <table
            class="table table-bordered">
            <thead>
            <tr class="bg-gray">
                @foreach($ticket->visits as $visit)
                    <th class="col-1">
                        {{$visit->date}}
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($ticket->visits as $visit)
                    <td class="col-1">
                        @if($visit->visited === 1)
                            <span class="bg-success">Посетил</span>
                        @else
                            <span class="bg-danger">Пропустил</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach($ticket->visits as $visit)
                    <td class="col-1">
                        {{mb_substr($visit->coach->name,0,1)}}
                        . {{mb_substr($visit->coach->patronymic,0,1)}}.
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach($ticket->visits as $visit)
                    <td>
                        <form action="/visit/{{$visit->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger">
                                Удалить
                            </button>
                        </form>

                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center mb-4">
            @if($ticket->is_closed !== 1)
                <button class="btn btn-success text-center mt-2 me-2">Сохранить</button>
                <button class="btn btn-danger text-center mt-2 me-2">
                    <a href="/profile/{{$profile->id}}/ticket/{{$ticket->id}}/close-ticket" class="text-decoration-none text-white">
                        Закрыть абонемент
                    </a>
                </button>
                @if($ticket->paused === 0)
                    <button class="btn btn-primary text-center mt-2 me-2">
                        <a href="/profile/{{$profile->id}}/ticket/{{$ticket->id}}/pause-ticket" class="text-decoration-none text-white">
                            Приостановить абонемент
                        </a>
                    </button>
                @else
                    <button class="btn btn-success text-center mt-2 me-2">
                        <a href="/profile/{{$profile->id}}/ticket/{{$ticket->id}}/resume-ticket" class="text-decoration-none text-white">
                            Возобновить абонемент
                        </a>
                    </button>
                @endif
            @else
                <button class="btn btn-success text-center mt-2 me-2">
                    <a href="/profile/{{$profile->id}}/ticket/{{$ticket->id}}/open-ticket" class="text-decoration-none text-white">
                        Открыть абонемент
                    </a>
                </button>
            @endif
        </div>
    </form>
    @if($ticket->is_closed !== 1)
    <form class="d-flex justify-content-center mt-2 mb-2" action="/visit" method="POST">
        @csrf
        <input type="hidden" name="coach_id" value="{{$profile->coach_id ?? 1}}">
        <input type="hidden" name="visited" value="1">
        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
        <input type="date" class="me-2" name="date">
        <button class="btn btn-primary">Добавить посещение</button>
    </form>
    @endif
@endsection
