{{ bs()->formGroup(bs()->text('name')->required()->placeholder('如：迎新茶會、新生茶會'))->class('required')->label('迎新茶會名稱')->showAsRow() }}
{{ bs()->formGroup(bs()->text('start_at')->required())->class('required')->label('開始時間')->showAsRow() }}
{{ bs()->formGroup(bs()->text('end_at')->required())->class('required')->label('結束時間')->showAsRow() }}
{{ bs()->formGroup(bs()->text('location')->required())->class('required')->label('地點')->showAsRow() }}
{{ bs()->formGroup(bs()->text('url')->placeholder('如：活動介紹頁面、FB宣傳文網址等'))->label('網址')->showAsRow() }}

@section('js')
    @parent
    <script>
        $(function () {
            $('input[name=start_at]').datetimepicker({
                format: 'Y-m-d H:i:00'
            });
            $('input[name=end_at]').datetimepicker({
                format: 'Y-m-d H:i:00'
            });
        });
    </script>
@endsection
