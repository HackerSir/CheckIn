@extends('layouts.app')

@section('title', '學生抽獎編號')

@section('content')
    <div class="mt-3 pb-3">
        <div class="card">
            <div class="card-body">
                <h1 class="display-3">學生抽獎編號查詢</h1>
                {{ Form::open(['method' => 'get', 'id' => 'ticket_search_form', 'class' => 'form-inline']) }}
                <input type="text" placeholder="學生抽獎編號" id="ticket_search_id" class="form-control mr-sm-2"
                       autocomplete="off">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search mr-2"></i>查詢
                </button>
                {{ Form::close() }}
                <div class="jumbotron text-center mt-3">
                    <h1 class="display-3" id="ticket_number"></h1>
                    <h1 class="display-3" id="ticket_name"></h1>
                    <h1 class="display-3" id="ticket_class"></h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            var $ticketInfo = $('#ticket_info');
            var $searchIdInput = $('#ticket_search_id');
            var $ticketNumber = $('#ticket_number');
            var $ticketName = $('#ticket_name');
            var $ticketClass = $('#ticket_class');
            var $cat = $('#cat');
            $searchIdInput.focus();
            $cat.hide();
            $('#ticket_search_form').submit(function () {
                //重置搜尋框
                var searchId = $searchIdInput.val();
                $searchIdInput.val('');
                $searchIdInput.focus();
                if (!searchId || $.trim(searchId).length === 0) {
                    return false;
                }
                //重置顯示區
                $cat.hide();
                $ticketNumber.text('');
                $ticketName.text('');
                $ticketClass.text('');
                //檢查ID
                if ($.isNumeric(searchId) === false) {
                    $cat.show();
                    $ticketNumber.text('#' + searchId);
                    $ticketName.html('<span style="color: red">抽獎編號是...數字( ﾟ Дﾟ）</span>');
                    return false;
                }
                //Loading
                $ticketInfo.addClass('loading');
                //透過Ajax查詢
                $.ajax({
                    url: '{{ route('student-ticket.info') }}',
                    type: 'GET',
                    data: {
                        id: searchId
                    },
                    error: function (xhr) {
                        $ticketName.html('<span style="color: red">發生錯誤</span>');
                    },
                    success: function (response) {
                        $ticketNumber.text('#' + response.id);
                        if (response.found) {
                            $ticketName.text(response.name);
                            $ticketClass.text(response.class);
                        } else {
                            $ticketName.html('<span style="color: red">查無此學生抽獎編號</span>');
                            $ticketClass.text('');
                        }
                    },
                    complete: function () {
                        //取消Loading
                        $ticketInfo.removeClass('loading');
                    }
                });
                return false;
            });
        });
    </script>
@endsection
