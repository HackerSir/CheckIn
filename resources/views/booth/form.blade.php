{{ bs()->formGroup(bs()->text('zone'))->label('攤位分區')->showAsRow() }}
{{ bs()->formGroup(bs()->text('name')->required()->placeholder('如：A01'))->class('required')->label('攤位編號')->showAsRow() }}
{{ bs()->formGroup(bs()->select('club_id')->options(\App\Club::selectOptions()))->label('社團')->showAsRow() }}
{{ bs()->formGroup(bs()->text('latitude')->required())->class('required')->label('緯度')->showAsRow() }}
{{ bs()->formGroup(bs()->text('longitude')->required())->class('required')->label('經度')->showAsRow() }}

@section('js')
    @parent
    <script>
        $(function () {
            $('select[name=club_id]').select2();
        });
    </script>
@endsection
