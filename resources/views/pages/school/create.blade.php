@extends('layouts.index')

@section('content')
    <div class="card col-xl-6 m-auto d-flex justify-content-center flex-column align-items-center mt-5 ">
        <h2 class="mt-3">Добавить зал</h2>
        <form method="POST"  action="/school" class="p-2 col-xl-9 text-center">
            @csrf
            <label for="name">Название зал <span class="text-danger">*</span></label>
            <div class="text-danger"> {{$errors->first('name')}} </div>
            <input class="form-control m-2" type="text" name="name" id="name" autocomplete="off" value="{{ old('name') }}">
            <label for="address">Адрес зала <span class="text-danger">*</span></label>
            <div class="text-danger"> {{$errors->first('address')}} </div>
            <input class="form-control m-2" type="text" name="address" id="address" autocomplete="off" value="{{ old('address') }}">
            <button class="btn btn-success m-3">Добавить</button>
            <div>Не обязательные для заполнения поля</div>
            <br>
            <div class="text-danger"> {{$errors->first('ticket_amount')}} </div>
            <label for="ticket_amount">Стоимость абонемента</label>
            <input class="form-control m-2" type="number" min="0" name="ticket_amount" id="ticket_amount" autocomplete="off" value="{{ old('ticket_amount') ?? $ticketAmount}}">
            <label for="description">Описание клуба</label>
            <div class="text-danger"> {{$errors->first("description")}} </div>
            <textarea class="form-control m-2" name="description" id="description" rows="5">
               {{ old('description') }}
            </textarea>
            <label for="contacts['phone']">Контактный телефон</label>
            <div class="text-danger"> {{$errors->first("contacts[phone]")}} </div>
            <input class="form-control m-2" type="tel" name="contacts[phone]" id="contacts[phone]" autocomplete="off"
                   value="{{ old("contacts[phone]") }}" placeholder="+71234567890">
            <label for="contacts[coach]">Ответственный за клуб</label>
            <div class="text-danger"> {{$errors->first("contacts[coach]")}} </div>
            <select name="contacts[coach]" id="contacts[coach]" class="form-control form-select m-2">
                <option value="">-</option>
                @isset($coaches)
                    @foreach($coaches as $coach)
                        <option value="{{$coach->id}}"
                        @if(\Illuminate\Support\Facades\Auth::user()->profile->id === $coach->id) selected @endif>
                            {{$coach->fullName}}
                        </option>
                    @endforeach
                @endisset
            </select>
        </form>
    </div>
@endsection
