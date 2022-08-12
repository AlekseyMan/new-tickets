@extends('layouts.index')

@section('content')
    <div class="container-xxl d-flex justify-content-center">
        <h2>{{$school->name . ": " . $school->address}}</h2>
    </div>
    <div class="table-responsive">
        <table
            class="table table-vcenter table-striped">
            <thead>
            <tr>
                <th class="col-xl-3 text-center">Выберите группу</th>
                @auth('sanctum')
                <th class="col-xl-5 text-center">Расписание</th>
                <th class="col-xl-2">Редактировать</th>
                <th class="col-xl-2">Удалить</th>
                @endauth
            </tr>
            </thead>
            <tbody>
            @foreach($school->groups as $group)
                <tr>
                    <td class="text-center cursor-pointer"
                        onclick="location.href='/group/{{ $group->id }}'">
                        <h3>{{$group->name}}</h3>
                    </td>
                    <td class="text-center cursor-pointer"
                        onclick="location.href='/group/{{ $group->id }}">
                        <h3>{{$group->schedule}}</h3>
                    </td>
                    @auth('sanctum')
                    <td class="text-muted">
                        Edit
                    </td>
                    <td class="text-muted">Delete</td>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="container-xxl d-flex justify-content-center">
            <a href="/group/create" class="text-decoration-none mt-5"><button class="btn btn-primary">Добавить группу</button></a>
        </div>
    </div>
@endsection
