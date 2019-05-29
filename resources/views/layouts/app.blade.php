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
    <meta property="og:description" content="2019 逢甲社團博覽會集點打卡">
    <meta property="og:type" content="website">

    <meta name="theme-color" content="#f8f9fa">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}">

    <title>{{ $title }}</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    {{-- DataTables --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    {{--<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">--}}
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset(mix('/build-css/select2-bootstrap4.min.css')) }}">
    {{-- toastr.js --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body > div:first-child {
            padding-top: 60px;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        body {
            background: url("{{ asset('img/background.jpg') }}") no-repeat fixed center / cover !important;
        }

        .toast-top-full-width {
            top: 60px;
        }

        .code {
            font-family: Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 120%;
        }

        @media (max-width: 1200px) {
            .navbar-collapse {
                max-height: calc(100vh - 56px);
                overflow-y: auto;
            }
        }

        .form-group.required label:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: " \f621";
            color: red;
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
{{-- DataTables --}}
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
{{--<script src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>--}}
<script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
{{--<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>--}}
<script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
{{-- toastr.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    //CSRF Token
    window.Laravel = <?php echo json_encode([
        'baseUrl'   => url('/'),
        'student'   => auth()->user()->student->nid ?? null
    ]); ?>
</script>
<script>
    $(function () {
        toastr.options = {
            "toastClass": "toastr",
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-full-width",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "3000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "3000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
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
        //DataTimePicker
        $.datetimepicker.setLocale('zh-TW');
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
    // DataTables 預設設定
    (function ($, DataTable) {
        $.extend(true, DataTable.defaults, {
            pageLength: 10,
            autoWidth: false,
            responsive: true,
            dom: "<'row'<'col-md-6'l><'col-md-6'f>><'row'<'col-md-12'rt>><'row'<'col-md-6'i><'col-md-6'p>>",
            stateSave: true,
            language: {
                "decimal": "",
                "emptyTable": "沒有資料",
                "thousands": ",",
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                "search": "搜尋：",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                },
                "aria": {
                    "sortAscending": ": 升冪排列",
                    "sortDescending": ": 降冪排列"
                }
            }
        });
        DataTable.ext.errMode = 'throw';
    })(jQuery, jQuery.fn.dataTable);
    // select2 預設設定
    $.fn.select2.defaults.set("theme", "bootstrap4");
</script>
@yield('js')

</body>
</html>
