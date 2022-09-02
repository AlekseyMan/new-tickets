@extends('layouts.index')

@section('content')
    <div class="col-6 m-auto">
        <h1 class="text-center">Списки спортсменов по командам</h1>
        @foreach($teams as $team)
            <h2 class="text-center">{{$team->name}}</h2>
            <table class="table table-vcenter">
                <thead>
                <tr>
                    <th class="col-6">Спортсмен</th>
                    <th class="col-6">Тренер</th>
                </tr>
                </thead>
                <tbody>
                @foreach($team->teamMembers as $member)
                    <tr>
                        <td>{{$member->fullName}}</td>
                        <td>
                            @foreach($coaches as $coach)
                                @if($coach->id === $member->coach_id)
                                    {{$coach->fullName}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @endforeach
    </div>
@endsection
