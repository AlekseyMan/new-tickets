@extends('layouts.index')

@section('content')
    <div class="col-xl-12 text-center">
        <h3 class="">{{$school->name}}</h3>
        <h5>{{$school->address}}</h5>
    </div>
    <div class="table-responsive">
        <table
            class="table table-vcenter table-striped">
            <thead>
            <tr>
                <th class="col-xl-2">Время</th>
                <th class="col-xl-2">Дни</th>
                <th class="col-xl-4">Тренер</th>
                @auth('sanctum')
                <th class="col-xl-2">Редактировать</th>
                <th class="col-xl-2">Удалить</th>
                @endauth
            </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr onclick="goTo('/group/{{$group->id}}')" class="cursor-pointer">
                    <td>{{$group->time_start}} - {{$group->time_end}}</td>
                    <td>
                        {{$group->days}}
                    </td>
                    <td>
                        {{$group->coach->surname}} {{$group->coach->name}} {{$group->coach->patronymic}}
                    </td>
                    @auth('sanctum')
                    <th class="col-xl-2">Редактировать</th>
                    <th class="col-xl-2">Удалить</th>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card col-xl-6 m-auto d-flex justify-content-center flex-column align-items-center mt-5 ">
        <h4 class="mt-3">Добавить группу</h4>
        <form method="POST" action="add-group"
              class="p-2 col-xl-9 text-center">
            @csrf
            <p>Выберите время группы</p>
            <div class="d-flex justify-content-center">
                <input class="form-control m-2 w-25" type="time" name="time_start" required>
                <input class="form-control m-2 w-25" type="time" name="time_end" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Выберите дни</label>
                <div class="form-selectgroup">
                    @foreach($days as $day)
                        <label class="form-selectgroup-item">
                            <input type="checkbox" name="days[]" value="{{$day->id}}" class="form-selectgroup-input">
                            <span class="form-selectgroup-label">{{$day->short}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <select name="coach" class="form-select">
                @foreach($coaches as $coach)
                    <option value="{{$coach->id}}">
                        {{$coach->surname . ' ' . $coach->name . ' ' . $coach->patronymic}}
                    </option>
                @endforeach
            </select>
            <button id="form-button" class="d-none"></button>
        </form>
        <button class="btn btn-success mb-4 mt-2" onclick="checkBoxChecking('form-button')">Добавить</button>
    </div>
@endsection
