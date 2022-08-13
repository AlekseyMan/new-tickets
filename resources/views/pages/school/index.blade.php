@extends('layouts.index')

@section('content')
    <div class="container-xxl d-flex justify-content-center">
        <a href="/school/create" class="text-decoration-none"><button class="btn btn-primary mb-3">Добавить зал</button></a>
    </div>
    <div class="table-responsive">
        <table
            class="table table-vcenter table-striped">
            <thead>
            <tr>
                <th class="col-xl-8 text-center">Выберите клуб</th>
                @auth('sanctum')
                <th class="col-xl-2">Редактировать</th>
                <th class="col-xl-2">Удалить</th>
                @endauth
            </tr>
            </thead>
            <tbody>
            @foreach($schools as $item)
                <tr>
                    <td class="text-center cursor-pointer"
                        onclick="location.href = '/school/{{ $item->id }}'">
                        <h3>{{$item->name . ": " . $item->address}}</h3>
                    </td>
                    @auth('sanctum')
                    <td class="text-muted">
                        <form action="/school/{{$item->id}}/edit" method="GET">
                            <button class="btn btn-primary">Редактировать</button>
                        </form>
                    </td>
                    <td class="text-muted">
                        <form action="/school/{{$item->id}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                    @endauth
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
