{{ bs()->formGroup(bs()->select('club_id', \App\Club::selectOptions(), !isset($teaParty) ? request('club_id') : null)->required())->class('required')->label('社團')->showAsRow() }}
@include('tea-party.common-form')

@section('js')
    @parent
    <script>
        $(function () {
            $('select[name=club_id]').select2();
        });
    </script>
@endsection
