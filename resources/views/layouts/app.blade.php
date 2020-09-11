<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    {{-- Metatag --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    @php
        $title = '';
        if(View::hasSection('title')) {
            $title = View::yieldContent('title') . ' - ';
        }
        $title .= config('app.name');
    @endphp

    <meta property="og:title" content="{{ $title }}">
    <meta property="og:url" content="{{ URL::current() }}">
    <meta property="og:image" content="@yield('og_image', asset('img/hacker.png'))">
    <meta property="og:description" content="2020 逢甲社團博覽會集點打卡">
    <meta property="og:type" content="website">

    <meta name="theme-color" content="#f8f9fa">
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}">

    @yield('meta')

    <title>{{ $title }}</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    {{-- DataTables --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    {{--<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">--}}
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset(mix('/build-css/select2-bootstrap4.min.css')) }}">
    {{-- toastr.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset(mix('/build-css/app.css')) }}">

    <style>
        body {
            background-image: url("{{ asset('img/background.jpg') }}") !important;
        }
    </style>
    @yield('css')
</head>
<body>
<div class="d-flex flex-column" id="vue-app" style="min-height:100vh;">
    {{-- Navbar --}}
    @include('components.navbar')
    {{-- Main Content --}}
    <main style="flex-grow:1; display: block!important;" class="d-flex mt-3 mb-3 @yield('container_class', 'container')"
          id="app">
        @if($xRequestedWithMessage ?? false)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                {{ $xRequestedWithMessage }}，這可能會使得<b>打卡通知</b>、<b>校內導航</b>等重要功能無法正確運作。<br/>
                請使用瀏覽器（如：Google Chrome）瀏覽本網站，詳情請見 {{ link_to_route('faq', '常見問題') }}。
            </div>
        @endif
        @yield('content')
    </main>
    {{-- Footer --}}
    @include('components.footer')
</div>

{{-- Javascript --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
{{-- DataTables --}}
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
{{--<script src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>--}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
{{--<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>--}}
<script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
{{-- toastr.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    //CSRF Token
    window.Laravel = <?php echo json_encode([
        'baseUrl' => url('/'),
        'student' => auth()->user()->student->nid ?? null
    ]); ?>
</script>
{{-- 各種 js 的設定 --}}
<script src="{{ asset(mix('build-js/options.js')) }}"></script>
<script>
    $(function () {
        @if(session('success'))
            toastr["success"]('{{ session('success') }}');
        @endif
            @if(session('info'))
            toastr["info"]('{{ session('info') }}');
        @endif
            @if(session('warning'))
            toastr["warning"]('{{ session('warning') }}');
        @endif
            @if(session('error'))
            toastr["error"]('{{ session('error') }}');
        @endif
        // Tooltip
        $('[title]:not(#tracy-debug *[title])').each(function () {
            $(this).tooltip({
                placement: 'right'
            });
        });
        // Google分析
        @if(config('services.google.analysis.id'))
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', '{{ config('services.google.analysis.id') }}', 'auto');
        ga('send', 'pageview');
        @endif
    });
</script>
@yield('js')

</body>
</html>
