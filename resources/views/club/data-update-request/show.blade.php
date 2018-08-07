@extends('layouts.base')

@section('title', '社團資料更新請求管理')

@section('buttons')
    <a href="{{ route('data-update-request.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團資料更新請求管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            @include('club.data-update-request.info', compact('dataUpdateRequest'))
        </div>
    </div>
    @if(is_null($dataUpdateRequest->review_result))
        <div class="card mt-2">
            <div class="card-header">審核</div>
            <div class="card-body">
                @component('bs::alert', ['type' => 'info'])
                    若審核通過，社團簡介將立刻更新<br/>
                    對於每筆申請，僅能審核一次，送出後將無法撤銷
                @endcomponent
                {{ bs()->openForm('patch', route('data-update-request.update', $dataUpdateRequest)) }}
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">審核者</label>
                    <div class="col-md-10">
                        <p class="form-control-plaintext">
                            {{ $user->display_name }}
                        </p>
                    </div>
                </div>
                {{ bs()->formGroup(bs()->radioGroup('review_result', [
                  'y' => '<span class="text-success"><i class="fas fa-fw fa-check"></i> 通過</span>',
                  'n' => '<span class="text-danger"><i class="fas fa-fw fa-times"></i> 不通過</span>',
                  ]))->label('審核結果')->showAsRow() }}
                {{ bs()->formGroup(bs()->text('review_comment')->placeholder('若審核不通過，請說明原因'))->label('審核評語')->showAsRow() }}
                <div class="row">
                    <div class="mx-auto">
                        {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                    </div>
                </div>
                {{ bs()->closeForm() }}
            </div>
        </div>
    @endif
@endsection
