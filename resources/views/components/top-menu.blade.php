<div class="d-flex justify-content-center">
    <a href="/"><button class="m-3 btn btn-secondary">Главная</button></a>
    <a href="/school"><button class="m-3 btn btn-secondary">Школы</button></a>
    <a href=""><button class="m-3 btn btn-secondary">Тренера</button></a>
    <a href="/karateki"><button class="m-3 btn btn-secondary">Ученики</button></a>
    @auth
    <a href="{{ route('logout') }}"><button class="m-3 btn btn-secondary">Выйти</button></a>
    @else
        <a href="{{ route('login') }}"><butoon class="btn btn-cyan m-3">Войти</butoon></a>
    @endauth
</div>
