@extends('layouts.app')

@section('title', '編輯社團')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $club->name }} - 編輯社團</h1>
            <div class="card">
                <div class="card-block">
                    {{ Form::model($club, ['route' => 'own-club.update', 'method' => 'patch', 'files' => true]) }}

                    <div class="form-group row">
                        <label for="number" class="col-md-2 col-form-label">社團編號</label>
                        <div class="col-md-10">
                            {{ Form::text('number', null, ['class' => 'form-control', 'disabled']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">名稱</label>
                        <div class="col-md-10">
                            {{ Form::text('name', null, ['class' => 'form-control', 'disabled']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="club_type_id" class="col-md-2 col-form-label">社團類型</label>
                        <div class="col-md-10">
                            {{ Form::select('club_type_id', \App\ClubType::selectOptions(), null, ['class' => 'form-control', 'disabled']) }}
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="description" class="col-md-2 col-form-label">描述</label>
                        <div class="col-md-10">
                            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                            @if ($errors->has('description'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('url') ? ' has-danger' : '' }}">
                        <label for="url" class="col-md-2 col-form-label">網址</label>
                        <div class="col-md-10">
                            {{ Form::url('url', null, ['class' => 'form-control', 'placeholder' => '網站、粉絲專頁等']) }}
                            @if ($errors->has('url'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($club->imgurImage)
                        <div class="form-group row">
                            <label for="image_file" class="col-md-2 col-form-label">圖片</label>
                            <div class="col-md-10">
                                <p class="form-control-static">
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

                    <div class="form-group row{{ $errors->has('image_file') ? ' has-danger' : '' }}">
                        <label for="image_file" class="col-md-2 col-form-label">圖片上傳</label>
                        <div class="col-md-10">
                            {{ Form::file('image_file', ['class' => 'form-control', 'accept' => 'image/*']) }}
                            @if ($errors->has('image_file'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('image_file') }}</strong>
                                </span>
                            @endif
                            <small class="form-text text-muted">
                                檔案大小限制：
                                {{ app(\App\Services\FileService::class)->imgurUploadMaxSize() }}
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary"> 確認</button>
                            <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">返回</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
