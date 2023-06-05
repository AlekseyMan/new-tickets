@extends('layouts.index')
@section('content')
<div class="card">
    <div class="table-responsive">
        <table
            class="table table-vcenter table-striped">
            <thead>
                <tr>
                    <th class="col-xl-2">Дата</th>
                    <th class="col-xl-2">ФИО спортсмена</th>
                    <th class="col-xl-4">Действие</th>
                    <th class="col-xl-2">Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $data['opened'] as $opened)
                    <tr class="">
                        <td class="col-xl-2">
                            {{$opened['date']}}
                        </td>
                        <td class="col-xl-4">
                            {{$opened['name']}}
                        </td>
                        <td class="col-xl-3">
                            {{$opened['action']}}
                        </td>
                        <td class="col-xl-2">
                            -
                        </td>
                    </tr>
                @endforeach
                <tr class="">
                    <td class="bg-info"></td>
                    <td class="bg-info"></td>
                    <td class="bg-info"></td>
                    <td class="bg-info"></td>
                </tr>
                @foreach( $data['payments'] as $payment)
                <tr class="">
                    <td class="col-xl-2">
                        {{$payment['date']}}
                    </td>
                    <td class="col-xl-4">
                        {{$payment['name']}}
                    </td>
                    <td class="col-xl-3">
                        {{$payment['action']}}
                    </td>
                    <td class="col-xl-2">
                        {{$payment['amount']}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
