@extends('layouts.base')

@section('title', '申請修改社團資料')

@section('buttons')
    <a href="{{ route('own-club.data-update-request.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection
@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('own-club.data-update-request.store'), ['model' => $club, 'files' => true]) }}
            @if($previousDataUpdateRequest = $club->dataUpdateRequests()->whereNull('review_result')->first())
                <div class="alert alert-danger">
                    仍有申請正等待審核中，若重新提交申請，將自動撤銷前一次的申請
                </div>
            @endif
            <div class="alert alert-info">
                請確實填寫申請原因，以利審核流程進行
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">申請者</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {{ $user->display_name }}
                    </p>
                </div>
            </div>
            {{ bs()->formGroup(bs()->text('reason')->required())->label('申請原因')->showAsRow() }}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">社團</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {!! $club->display_name ?? '' !!}
                    </p>
                </div>
            </div>
            {{ bs()->formGroup(bs()->textarea('description')->attribute('rows', 10))->label('描述')->showAsRow() }}
            {{ bs()->formGroup(bs()->textarea('extra_info')->attribute('rows', 10))->label('額外資訊')->helpText('僅限對此社團填寫回饋資料的學生檢視，可放FB社團、LINE群網址等')->showAsRow() }}
            {{ bs()->formGroup(bs()->input('url', 'url')->placeholder('網站、粉絲專頁等'))->label('網址')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
