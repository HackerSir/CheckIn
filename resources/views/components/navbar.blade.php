<nav class="navbar navbar-expand-xl fixed-top navbar-light bg-light">
    <div class="container" style="justify-content: left">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand font-weight-bold" style="margin-left: 1rem" href="{{ url('/') }}">
            {{ config('app.cht_name') }}
        </a>
        <ul class="navbar-nav d-flex flex-row d-xl-none ml-auto">
            <li class="nav-item" style="font-size: 20px">
                <a href="{{ route('my-qrcode') }}" class="nav-link"><i class="fas fa-qrcode mx-2"></i></a>
            </li>
            @if(auth()->user()->club)
                <li class="nav-item" style="font-size: 20px">
                    <a href="{{ route('qrcode.web-scan') }}" class="nav-link"><i class="fas fa-camera mx-2"></i></a>
                </li>
            @endif
        </ul>

        {{-- Item 會由 LaravelMenu 生成 --}}
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- 左側選單 --}}
            <ul class="navbar-nav">
                @include(config('laravel-menu.views.bootstrap-items'), ['items' => Menu::get('left')->roots()])
            </ul>
            {{-- 右側選單 --}}
            <ul class="navbar-nav ml-auto">
                @include(config('laravel-menu.views.bootstrap-items'), ['items' => Menu::get('right')->roots()])
            </ul>
        </div>
    </div>
</nav>
