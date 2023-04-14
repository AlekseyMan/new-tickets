@extends('layouts.index')
@section('content')
    <div class="d-flex col-10 justify-content-center m-auto" id="token" data-token="{{ csrf_token() }}">
        <div class="text-center">
            <label >Тренер</label>
            <select name="coach" id="coach" class="form-select m-1">
                @foreach($coaches as $coach)
                    <option value="{{$coach->id}}">{{$coach->fullName}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3 text-center">
            <label>Месяц</label>
            <select name="month" id="month" class="form-select m-1">
                <option value="1">Январь</option>
                <option value="2">Февраль</option>
                <option value="3">Март</option>
                <option value="4">Апрель</option>
                <option value="5">Май</option>
                <option value="6">Июнь</option>
                <option value="7">Июль</option>
                <option value="8">Август</option>
                <option value="9">Сентябрь</option>
                <option value="10">Октябрь</option>
                <option value="11">Ноябрь</option>
                <option value="12">Декабрь</option>
            </select>
        </div>
        <div class="col-2 text-center">
            <label>Год</label>
            <select name="year" id="year" class="form-select m-1">
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
        </div>
    </div>
    <div class="mt-3 text-center">
        <div class="btn btn-success" onclick="getReport()">Отобразить</div>
    </div>
    <div class="card col-8 m-auto mt-3">
        <div class="card-header text-center">
            <b class="m-auto"><h2>Статистика</h2></b>
        </div>
        <div class="card-body">
            <div class="text-center">
                <b><p>Всего открыто абонементов за месяц: <span id="tickets-open">0</span></p><br></b>
                <b><p>Всего куплено абонементов за месяц: <span id="tickets-buyed">0</span></p></b>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-center" id="school-statistics">

            </div>
            <div id="report-button">

            </div>
        </div>
    </div>
    <script>
        async function getReport(){
            const coach         = document.getElementById('coach')
            const month         = document.getElementById('month')
            const year          = document.getElementById('year')
            const token         = document.getElementById('token').dataset.token
            const block         = document.getElementById('school-statistics')
            const reportBlock   = document.getElementById('report-button')
            block.innerHTML         = ""
            block.innerHTML         = "<h3>Статистика по школам:</h3>"
            reportBlock.innerHTML   = ""
            let response = await fetch('/tickets/get-info', {
                method: 'POST',
                headers: new Headers({
                    'Content-Type': 'application/json'
                }),
                body: JSON.stringify({
                    month       : month.options[month.selectedIndex].value,
                    year        : year.options[year.selectedIndex].value,
                    coach_id    : coach.options[coach.selectedIndex].value,
                    _token      : token
                }),
            });
            let res = await response.json()
            document.getElementById('tickets-open').innerText = res.opened
            document.getElementById('tickets-buyed').innerText = res.paid
            for(let name in res.schools){
                if(res.schools[name].opened > 0 || res.schools[name].paid > 0) {
                    let elem = document.createElement('div')
                    elem.innerHTML = "<b><p>"+ name +"</p></b>" +
                        "<p>Открыто: "+ res.schools[name].opened +"</p>" +
                        "<p>Куплено: "+ res.schools[name].paid +"</p>"
                    block.insertAdjacentElement("beforeend", elem)
                }
            }
            let formElement = document.createElement('form')
            formElement.action = '/settings/reports'
            formElement.method = 'POST'
            formElement.className = "text-center"
            formElement.innerHTML = '<input type="hidden" name="coach_id" value="' + coach.options[coach.selectedIndex].value + '">' +
                '<input type="hidden" name="year" value="' + year.options[year.selectedIndex].value + '">' +
                '<input type="hidden" name="month" value="' + month.options[month.selectedIndex].value + '">' +
                '<input type="hidden" name="_token" value="' + token + '">' +
                '<button class="btn btn-success">Подробнее</button>'
            reportBlock.insertAdjacentElement('beforeend', formElement)
        }
    </script>
@endsection
