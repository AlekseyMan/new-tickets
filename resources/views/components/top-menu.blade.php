<div class="d-flex justify-content-center">
    <a href="/school" class="text-decoration-none"><button class="m-3 btn btn-secondary">Залы</button></a>
    <a href="/coaches" class="text-decoration-none"><button class="m-3 btn btn-secondary">Тренера</button></a>
    <a href="/karateki?coach_id={{\Illuminate\Support\Facades\Auth::user()->profile->id ?? ""}}" class="text-decoration-none"><button class="m-3 btn btn-secondary">Ученики</button></a>
    <a href="/teams?coach_id={{\Illuminate\Support\Facades\Auth::user()->profile->id ?? ""}}" class="text-decoration-none"><button class="m-3 btn btn-secondary">Команды</button></a>
    <a href="/settings" class="text-decoration-none"><button class="m-3 btn btn-secondary">Настройки</button></a>
    @auth
    <a href="{{ route('logout') }}" class="text-decoration-none"><button class="m-3 btn btn-secondary">Выйти</button></a>
    @else
        <a href="{{ route('login') }}" class="text-decoration-none"><butoon class="btn btn-cyan m-3">Войти</butoon></a>
    @endauth
</div>
