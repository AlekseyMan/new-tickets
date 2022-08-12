@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <h2>{{$profile->surname}} {{$profile->name}}</h2>
        </div>
        @foreach($tickets as $ticket)
            @isset($ticket['allVisits'])
                <h3 class="text-center">Абонемент №{{$ticket->id}} @if($ticket->is_closed === 1) <span class="text-danger">(закрыт)</span> @endif</h3>
                <p class="text-center text-primary">Дата начала: {{mb_substr($ticket->created_at, 0, 10)}}</p>
                @if($ticket->paused === 0)
                    <p class="text-center text-primary">Дата окончания: {{$ticket->end_date}}</p>
                @else
                    <p class="text-center text-danger">Приостановлен с : {{$ticket->pause_date}}</p>
                @endif
                <table
                    class="table table-bordered">
                    <thead>
                    <tr class="bg-gray">
                        @foreach($ticket['allVisits'] as $visit)
                            <th class="col-1">
                                {{$visit->date}}
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($ticket['allVisits'] as $visit)
                            <td>
                                @if($visit->visited === 1)
                                    <span class="bg-success">Посетил</span>
                                @else
                                    <span class="bg-danger">Пропустил</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($ticket['allVisits'] as $visit)
                            <td>
                                {{mb_substr($visit->coachProfile->name,0,1)}}
                                . {{mb_substr($visit->coachProfile->patronymic,0,1)}}.
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($ticket['allVisits'] as $visit)
                            <td>
                                <button class="btn-primary">Удалить</button>
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mb-4">
                    <button class="btn-success text-center mt-2 me-2">Добавить посещение/пропуск в Абонемент
                        №{{$ticket->id}}</button>
                    @if($ticket->is_closed !== 1)
                        @if($ticket->paused === 0)
                            <button class="btn-primary text-center mt-2 me-2">Приостановить абонемент</button>
                        @else
                            <button class="btn-success text-center mt-2 me-2">Возобновить абонемент</button>
                        @endif
                    @endif
                </div>
            @endisset
        @endforeach
    </div>
@endsection
