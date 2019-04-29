<nav class="navbar navbar-expand-xl fixed-top navbar-light bg-light">
    <div class="container" style="justify-content: left">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand font-weight-bold" style="margin-left: 1rem" href="{{ url('/') }}">
            {{ config('app.cht_name') }}
        </a>

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
