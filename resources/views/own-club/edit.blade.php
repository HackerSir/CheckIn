@extends('layouts.base')

@section('title', '編輯社團')

@section('buttons')
    <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection
@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('own-club.update'), ['model' => $club, 'files' => true]) }}
            {{ bs()->formGroup(bs()->text('number')->disabled())->label('社團編號')->showAsRow() }}
            {{ bs()->formGroup(bs()->text('name')->disabled())->label('名稱')->showAsRow() }}
            {{ bs()->formGroup(bs()->select('club_type_id')->options(\App\ClubType::selectOptions())->disabled())->label('社團類型')->showAsRow() }}
            <hr/>
            {{ bs()->formGroup(bs()->textarea('description')->attribute('rows', 10)->class('tinymce'))->label('描述')->showAsRow() }}
            {{ bs()->formGroup(bs()->textarea('extra_info')->attribute('rows', 10)->class('tinymce'))->label('額外資訊')->helpText('僅限對此社團填寫回饋資料的學生檢視，可放FB社團、LINE群網址等')->showAsRow() }}
            {{ bs()->formGroup(bs()->input('url', 'url')->placeholder('網站、粉絲專頁等'))->label('網址')->showAsRow() }}

            @if($club->imgurImage)
                <div class="form-group row">
                    <label for="image_file" class="col-md-2 col-form-label">圖片</label>
                    <div class="col-md-10">
                        <p class="form-control-plaintext">
                            <img src="{{ $club->imgurImage->thumbnail('t') }}">
                            <a href="{{ $club->imgurImage->url }}" target="_blank">
                                {{ $club->imgurImage->file_name }}
                            </a>
                        </p>
                        <small class="form-text text-muted">
                            若不更換圖片，下欄請留空
                        </small>
                    </div>
                </div>
            @endif

            {{ bs()->formGroup(bs()->simpleFile('image_file')->acceptImage())->label('圖片上傳')
            ->helpText('檔案大小限制：'. app(\App\Services\FileService::class)->imgurUploadMaxSize())->showAsRow() }}
            {{ bs()->formGroup(bs()->text('custom_question'))->label('自訂問題')
            ->helpText('學生填寫回饋資料時，可一併詢問一個問題')->showAsRow() }}

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection

@section('js')
    @include('components.tinymce')
@endsection
