@extends('layouts.index')

@section('content')
    <div class="table-responsive">
        <div class="col-xl-12 d-flex justify-content-center m-3" id="token" data-token="{{ csrf_token() }}">
            <button type="button" class="btn btn-success">
                <a href="/coaches/create" class="text-decoration-none text-white">Добавить тренера</a>
            </button>
        </div>
        <table class="table table-vcenter">
            <thead>
            <tr>
                <th class="col-3 text-center">Фамилия Имя</th>
                <th class="col-2 text-center">Дата рождения</th>
                <th class="col-1 text-center">Кю/Дан</th>
                <th class="col-1 text-center">Вес</th>
                <th class="col-1">Редактировать</th>
            </tr>
            </thead>
            <tbody id="tbody">
            @isset($coaches)
                @foreach($coaches as $coach)
                    <tr class="text-center">
                        <td>
                            {{$coach->fullName}}
                        </td>
                        <td>{{$coach->birthday}}</td>
                        <td>{{ $coach->dan ? $coach->dan . " дан" : $coach->qu . " кю"}}</td>
                        <td>{{$coach->weight}}</td>
                        <td class="text-muted">
                            <form action="/coaches/{{$coach->id}}/edit" method="GET">
                                <button class="btn btn-primary">Редактировать</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
    </div>
@endsection

