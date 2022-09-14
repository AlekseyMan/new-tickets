@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <h2>{{$profile->fullName}}</h2>
        </div>
        <div class="col-xl-12 d-flex justify-content-center m-3" id="shown-balance">
            <h4 class="m-2">Баланс: {{$profile->balance}}</h4>
            <button class="btn btn-dark" id="shown-balance-button">Изменить</button>
        </div>
        <form action="/balance/{{$profile->id}}/update-balance" method="POST" id="edit-balance"
              class="col-xl-12 text-center m-3 d-none">
            @csrf
            <h4 class="m-2">Текущий баланс: {{$profile->balance}}</h4><br>
            <div class="d-flex justify-content-center">
                <h4 class="m-2">Добавить к балансу: <input type="number" name="amount" value=""></h4>
                <button class="btn btn-dark" id="edit-balance-button">Сохранить</button>
            </div>
        </form>
        <script>
            document.getElementById('shown-balance-button').addEventListener('click',()=>{
                document.getElementById('shown-balance').classList.add('d-none')
                document.getElementById('edit-balance').classList.remove('d-none')
            })
            document.getElementById('edit-balance-button').addEventListener('click',()=>{
                document.getElementById('edit-balance').classList.add('d-none')
                document.getElementById('shown-balance').classList.remove('d-none')
            })
        </script>
        @foreach($profile->tickets as $ticket)
            @isset($ticket->visits)
                <h3 class="text-center">Абонемент №{{$ticket->id}} @if($ticket->is_closed === 1)
                        <span class="text-danger">(закрыт)</span>
                    @endif</h3>
               <div class="d-flex justify-content-center">
                   @if($ticket->paused === 0)
                       <p class="text-center text-primary">С {{date("d-m-Y", strtotime($ticket->created_at))}} </p>
                       <p class="text-center text-primary">&nbsp; по {{date("d-m-Y", strtotime($ticket->end_date))}}</p>
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
                                {{date("d-m-Y", strtotime($visit->date))}}
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
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mb-4">
                    <button class="btn btn-success text-center mt-2 me-2"><a href="ticket/{{$ticket->id}}/edit" class="text-decoration-none text-white">Редактировать абонемент№{{$ticket->id}}</a></button>
                    @if($ticket->is_closed !== 1)
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
                    @endif
                </div>
            @endisset
        @endforeach
    </div>
@endsection
