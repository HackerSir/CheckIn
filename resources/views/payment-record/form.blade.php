@if(Laratrust::isAbleTo('payment-record.manage'))
    {{ bs()->formGroup(bs()->select('club_id', \App\Models\Club::selectOptions())->required())->class('required')->label('社團')->showAsRow() }}
@else
    {{ bs()->formGroup(bs()->select('club_id', \App\Models\Club::selectOptions(), $user->club->id)->disabled())->label('社團')->showAsRow() }}
    {{ bs()->hidden('club_id', $user->club->id) }}
@endif
{{ bs()->formGroup(bs()->text('nid')->required())->class('required')->label('NID')->showAsRow() }}
{{ bs()->formGroup(bs()->text('name'))->label('姓名')->showAsRow() }}
{{ bs()->formGroup(bs()->checkBox('is_paid', '已付清'))->label('繳費狀況')->showAsRow() }}
{{ bs()->formGroup(bs()->text('handler'))->label('經手人')->showAsRow() }}
{{ bs()->formGroup(bs()->text('note'))->label('備註')->showAsRow() }}

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

