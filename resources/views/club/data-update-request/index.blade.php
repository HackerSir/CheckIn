@extends('layouts.base')

@section('title', '社團資料修改申請管理')

@section('buttons')
    {{ bs()->openForm('get', route('data-update-request.index'), ['inline' => true]) }}
    {{ bs()->inputGroup(bs()->select('club_id', \App\Club::selectOptions(), request('club_id')))->prefix('社團') }}
    {{ bs()->inputGroup(bs()->select('result', [
        null => '',
        'wait' => '等待審核',
        'pass' => '通過',
        'fail' => '不通過'
    ], request('result')))->prefix('審核結果') }}
    {{ bs()->submit('過濾') }}
    {{ bs()->closeForm() }}
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
    </div>
@endsection

@section('js')
    {!! $dataTable->scripts() !!}
    <script>
        $(function () {
            $('select[name=club_id]').select2();
        });
    </script>
@endsection
