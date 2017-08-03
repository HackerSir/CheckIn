@extends('layouts.app')

@section('title', '額外抽獎編號')

@section('css')
    <style>
        h1 {
            font-size: 72px;
        }
        #ticket_info {
            padding-top: 30px;
            padding-bottom: 50px;
        }
        #ticket_info p {
            line-height: 50px;
        }
        p#ticket_number {
            font-size: 96px;
        }
        p#ticket_name {
            font-size: 120px;
        }
        p#ticket_class {
            font-size: 72px;
            line-height: normal;
        }
    </style>
@endsection

@section('content')
    <div class="mt-3 pb-3">
        <h1>額外抽獎編號</h1>
        <div class="card mt-1">
            <div class="card-block">
                {{ Form::open(['method' => 'get', 'id' => 'ticket_search_form']) }}
                <input type="text" placeholder="額外抽獎編號" id="ticket_search_id">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i> 查詢
                </button>
                {{ Form::close() }}
            </div>
            <div class="card-block">
                <p id="ticket_number"></p>
                <img src="{{ asset('img/cat.jpg') }}" id="cat" style="display:none;">
                <p id="ticket_name"></p>
                <p id="ticket_class"></p>
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
                    $ticketName.html('<span style="color: red">額外抽獎編號是...數字</span>');
                    return false;
                }
                //Loading
                $ticketInfo.addClass('loading');
                //透過Ajax查詢
                $.ajax({
                    url: '{{ route('extra-ticket.info') }}',
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
                            $ticketName.html('<span style="color: red">查無此額外抽獎編號</span>');
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
