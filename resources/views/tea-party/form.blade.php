@if(!isset($teaParty) && request('club_id'))
    {{ bs()->formGroup(bs()->select('club_id', \App\Club::selectOptions(), request('club_id'))->disabled())->label('社團')->showAsRow() }}
    {{ bs()->hidden('club_id', request('club_id')) }}
@else
    {{ bs()->formGroup(bs()->select('club_id', \App\Club::selectOptions())->required())->class('required')->label('社團')->showAsRow() }}
@endif

@include('tea-party.common-form')

@section('js')
    @parent
    @unless(!isset($teaParty) && request('club_id'))
        <script>
            $(function () {
                $('select[name=club_id]').select2();
            });
        </script>
    @endunless
@endsection
