@extends('layouts.index')

@section('content')
    <div class="d-flex justify-content-center">
        <form action="/coaches/{{$coach->id}}" method="POST" class="card col-8">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="card-header">
                <h3 class="">Редактировать данные тренера</h3>
            </div>
            <div class="card-body">
                <label for="surname"><b>Введите фамилию</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="surname" placeholder="Введите фамилию"
                       autocomplete="off" required value="{{$coach->surname}}">

                <label for="name"><b>Введите имя</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="name" placeholder="Введите имя"
                       autocomplete="off" required value="{{$coach->name}}">

                <label for="patronymic"><b>Введите отчество</b><span class="text-danger"> *</span></label>
                <input type="text" class="form-control mb-3" name="patronymic" placeholder="Введите отчество"
                       autocomplete="off" required value="{{$coach->patronymic}}">
                <div>
                    <div class="form-select mt-2 cursor-pointer" onclick="hideShowAdvancedBlock()"><b>Дополнительные
                            параметры</b></div>
                    <div class="form-control d-none" id="advanced-block">

                        <label for="birthday">Дата рождения</label>
                        <input type="date" value="{{$coach->birthday}}" name="birthday" class="form-control mb-2">
                        <label for="weight">Вес</label>
                        <input type="text" value="{{$coach->weight}}" name="weight" class="form-control mb-2"
                               placeholder="000,00">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn btn-secondary me-3">
                    <a href="{{ URL::previous() }}" class="text-decoration-none text-white">Отмена</a>
                </div>
                <button class="btn btn-primary me-3">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
    <script>
        function hideShowAdvancedBlock() {
            let target = document.getElementById("advanced-block").className
            if (target === "form-control") {
                document.getElementById("advanced-block").className = "form-control d-none"
            } else {
                document.getElementById("advanced-block").className = "form-control"
            }
        }
    </script>
@endsection
