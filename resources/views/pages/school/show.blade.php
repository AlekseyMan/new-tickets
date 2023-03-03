@extends('layouts.index')

@section('content')
    <div class="col-xl-8 text-start m-auto">
        <a href="/school">Список школ</a>
        \
        {{$school->name}}
    </div>
    <div class="col-xl-12 text-center">
        <h3 class="">{{$school->name}}</h3>
        <h5>{{$school->address}}</h5>
    </div>
    <div class="table-responsive">
        <table
            class="table table-vcenter table-striped">
            <thead>
            <tr>
                <th class="col-xl-2">Группа</th>
                <th class="col-xl-2">Расписание</th>
                <th class="col-xl-4">Тренер</th>
                <th class="col-xl-2">Редактировать</th>
                <th class="col-xl-2">Удалить</th>
            </tr>
            </thead>
            <tbody>
            @foreach($school->groups as $group)
                <tr class="">
                    <td>
                        <form action="/group/{{$group->id}}">
                            <button class="btn btn-success">{{$group->name}}</button> ({{count($group->karateki)}})
                        </form>
                    </td>
                    <td>
                        {{$group->formatedSchedule}}
                    </td>
                    <td>
                        @isset($group->coach)
                            {{$group->coach->surname}} {{$group->coach->name}} {{$group->coach->patronymic}} ({{$group->ticket_amount}})
                        @endisset
                    </td>
                    <td class="col-xl-2">
                        <form action="/group/{{$group->id}}/edit" method="GET">
                            <button class="btn btn-primary">Редактировать</button>
                        </form>
                    </td>
                    <td class="col-xl-2">
                        <form action="/group/{{$group->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card col-xl-6 m-auto d-flex justify-content-center flex-column align-items-center mt-5 ">
        <h4 class="mt-3">Добавить группу</h4>
        <form method="POST" action="/group"
              class="p-2 col-xl-9 text-center">
            <input type="hidden" name="school_id" value="{{$school->id}}">
            @csrf
            <label for="name">Название группы</label>
            <input type="text" class="form-control m-2" name="name" value="{{old('name')}}">
            <p>Выберите время группы</p>
            <div class="d-flex justify-content-center">
                <input class="form-control m-2 w-25" type="time" name="schedule[times][]" required>
                <input class="form-control m-2 w-25" type="time" name="schedule[times][]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Выберите дни</label>
                <div class="form-selectgroup">
                    @foreach($school->days as $shortDay => $fullDayName)
                        <label class="form-selectgroup-item">
                            <input type="checkbox" name="schedule[days][]" value="{{$shortDay}}" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">{{$shortDay}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <select name="coach_id" class="form-select">
                @foreach($coaches as $coach)
                    <option value="{{$coach->id}}" @if(\Illuminate\Support\Facades\Auth::user()->profile->id === $coach->id) selected @endif>
                        {{$coach->fullName}}
                    </option>
                @endforeach
            </select>
            <br>
            <div class="text-danger"> {{$errors->first('ticket_amount')}} </div>
            <label for="ticket_amount">Стоимость абонемента</label>
            <input class="form-control m-2" type="number" min="0" name="ticket_amount" id="ticket_amount" autocomplete="off" value="{{ old('ticket_amount') ?? $school->ticket_amount}}">
            <button class="btn btn-success mb-4 mt-2">Добавить</button>
        </form>

    </div>
@endsection
