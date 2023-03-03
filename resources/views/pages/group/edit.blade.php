@extends('layouts.index')

@section('content')
    <div class="col-xl-8 text-center m-auto mt-2">
        <a href="/school/{{$school->id}}">{{$school->name}}</a>
    </div>
    <div class="card col-xl-6 m-auto d-flex justify-content-center flex-column align-items-center mt-2">
        <h4 class="mt-3">Добавить группу</h4>
        <form method="POST" action="/group/{{$group->id}}"
              class="p-2 col-xl-9 text-center">
            <input type="hidden" name="school_id" value="{{$school->id}}">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <label for="name">Название группы</label>
            <input type="text" class="form-control m-2" name="name" value="{{old('name') ?? $group->name}}">
            <p>Выберите время группы</p>
            <div class="d-flex justify-content-center">
                <input class="form-control m-2 w-25" type="time" name="schedule[times][]" required value="{{json_decode($group->schedule, true)['times'][0]}}">
                <input class="form-control m-2 w-25" type="time" name="schedule[times][]" required value="{{json_decode($group->schedule, true)['times'][1]}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Выберите дни</label>
                <div class="form-selectgroup">
                    @foreach($school->days as $shortDay => $fullDayName)
                        <label class="form-selectgroup-item">
                            <input type="checkbox" name="schedule[days][]" value="{{$shortDay}}" class="form-selectgroup-input"
                            @if(in_array($shortDay, json_decode($group->schedule, true)['days'])) checked @endif>
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
            <input class="form-control m-2" type="number" min="0" name="ticket_amount" id="ticket_amount" autocomplete="off" value="{{ old('ticket_amount') ?? $group->ticket_amount}}">
            <button class="btn btn-success mb-4 mt-2">Сохранить</button>
        </form>

    </div>
@endsection
