@extends('layouts.app')

@section('content')
    <div class="mt-3 pb-3">
        <h1>@yield('title')</h1>
        <div class="d-flex flex-column flex-md-row flex-wrap">
            <div class="mb-2">
                @yield('buttons')
            </div>
            <div class="ml-md-auto">
                @yield('buttons-right')
            </div>
        </div>
        <div class="mt-1 mb-3">
            @yield('main_content')
        </div>
    </div>
@endsection
