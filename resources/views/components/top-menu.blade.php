<div class="d-flex justify-content-center">
    <a href="/school"><button class="m-3 btn btn-secondary">Залы</button></a>
    <a href="/coaches"><button class="m-3 btn btn-secondary">Тренера</button></a>
    <a href="/karateki"><button class="m-3 btn btn-secondary">Ученики</button></a>
    <a href="/settings"><button class="m-3 btn btn-secondary">Настройки</button></a>
    @auth
    <a href="{{ route('logout') }}"><button class="m-3 btn btn-secondary">Выйти</button></a>
    @else
        <a href="{{ route('login') }}"><butoon class="btn btn-cyan m-3">Войти</butoon></a>
    @endauth
</div>
