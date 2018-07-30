<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    {{-- Metatag --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta property="og:title" content="@yield('title')::{{ config('app.name') }}">
    <meta property="og:url" content="{{ URL::current() }}">
    <meta property="og:image" content="@yield('og_image', asset('img/hacker.png'))">
    <meta property="og:description" content="2017 逢甲社團博覽會集點打卡">
    <meta property="og:type" content="website">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}">

    <title>@yield('title')::{{ config('app.name') }}</title>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.9.0/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.9.0/css/themes/bootstrap.min.css"/>
    {{-- DataTables --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    {{--<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">--}}
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <style>
        {{-- https://github.com/twbs/bootstrap/issues/21590 --}}
        @media (max-width: 576px) {
            nav > .container {
                margin-left: 0;
                margin-right: 0;
            }
        }

        body > .container {
            padding-top: 60px;
            min-height: calc(100vh - 86px);
        }

        .table td, .table th {
            vertical-align: middle;
        }

        body {
            background: url("{{ asset('img/background.jpg') }}") no-repeat fixed center !important;
        }

        {{-- 讓 AlertifyJS 的 notify 往下一點，才不會擋到 navbar --}}
        .alertify-notifier.ajs-top {
            top: 60px;
        }

        .code {
            font-family: Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 120%;
        }
    </style>
    @yield('css')
</head>
<body>
{{-- Navbar --}}
@include('components.navbar')

{{-- Content --}}
<div class="container" id="vue-app">
    @yield('content')
</div>

{{-- Footer --}}
@include('components.footer')

{{-- Javascript --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/alertifyjs/1.9.0/alertify.min.js"></script>
<script src="https://use.fontawesome.com/544fc47aab.js"></script>
{{-- DataTables --}}
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
{{--<script src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>--}}
<script src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
{{--<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>--}}
<script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js"></script>
<script>
    //CSRF Token
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'baseUrl'   => url('/'),
    ]); ?>
</script>
<script>
    $(function () {
        //AlertifyJS
        alertify.defaults = {
            autoReset: true,
            basic: false,
            closable: true,
            closableByDimmer: true,
            frameless: false,
            maintainFocus: true, // <== global default not per instance, applies to all dialogs
            maximizable: true,
            modal: true,
            movable: true,
            moveBounded: false,
            overflow: true,
            padding: true,
            pinnable: true,
            pinned: true,
            preventBodyShift: false, // <== global default not per instance, applies to all dialogs
            resizable: true,
            startMaximized: false,
            transition: 'pulse',
            notifier: {
                position: 'top-right'
            },
            // language resources
            glossary: {
                // dialogs default title
                title: 'AlertifyJS',
                // ok button text
                ok: 'OK',
                // cancel button text
                cancel: 'Cancel'
            },
            // theme settings
            theme: {
                // class name attached to prompt dialog input textbox.
                input: 'ajs-input',
                // class name attached to ok button
                ok: 'ajs-ok',
                // class name attached to cancel button
                cancel: 'ajs-cancel'
            }
        };
        @if(session('global'))
        alertify.notify('{{ session('global') }}', 'success', 5);
        @endif
        @if(session('warning'))
        alertify.notify('{{ session('warning') }}', 'warning', 5);
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
        @if(env('GOOGLE_ANALYSIS'))
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
        ga('create', '{{ env('GOOGLE_ANALYSIS') }}', 'auto');
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
    })(jQuery, jQuery.fn.dataTable);
</script>
@yield('js')

</body>
</html>
