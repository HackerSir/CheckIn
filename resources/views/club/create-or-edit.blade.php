@extends('layouts.base')

@php
    $isEditMode = isset($club);
    $methodText = $isEditMode ? '編輯' : '新增';
@endphp

@section('title', $methodText . '社團')

@section('buttons')
    @if($isEditMode)
        <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
        </a>
    @else
        <a href="{{ route('club.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團管理
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            @if($isEditMode)
                {{ Form::model($club, ['route' => ['club.update', $club], 'method' => 'patch', 'files' => true]) }}
            @else
                {{ Form::open(['route' => 'club.store', 'files' => true]) }}
            @endif

            <div class="form-group row{{ $errors->has('number') ? ' has-danger' : '' }}">
                <label for="number" class="col-md-2 col-form-label">社團編號</label>
                <div class="col-md-10">
                    {{ Form::text('number', null, ['class' => 'form-control', 'placeholder' => '如：A66']) }}
                    @if ($errors->has('number'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('number') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('name') ? ' has-danger' : '' }}">
                <label for="name" class="col-md-2 col-form-label">名稱</label>
                <div class="col-md-10">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => '如：黑客社', 'required']) }}
                    @if ($errors->has('name'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('club_type_id') ? ' has-danger' : '' }}">
                <label for="club_type_id" class="col-md-2 col-form-label">社團類型</label>
                <div class="col-md-10">
                    {{ Form::select('club_type_id', \App\ClubType::selectOptions(), null, ['class' => 'form-control']) }}
                    @if ($errors->has('club_type_id'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('club_type_id') }}</strong>
                        </span>
                    @endif
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

            @if($isEditMode && $club->imgurImage)
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

            <div class="form-group row{{ $errors->has('booth_id') ? ' has-danger' : '' }}">
                <label for="booth_id[]" class="col-md-2 col-form-label">攤位</label>
                <div class="col-md-10">
                    {{ Form::select('booth_id[]', [], null, ['id' => 'booth_id', 'class' => 'form-control', 'multiple']) }}
                    @if ($errors->has('booth_id'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('booth_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                <label for="user_id[]" class="col-md-2 col-form-label">攤位負責人</label>
                <div class="col-md-10">
                    {{ Form::select('user_id[]', [], null, ['id' => 'user_id', 'class' => 'form-control', 'multiple']) }}
                    @if ($errors->has('user_id'))
                        <span class="form-control-feedback">
                            <strong>{{ $errors->first('user_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="mx-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check" aria-hidden="true"></i> 確認
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            function formatTemplateBooth(booth) {
                if (booth.loading) return booth.text;
                if (!booth.name) return null;

                var markup = "<div class='container' style='width: 100%'><div class='row'>"
                    + "<div class='col-md-12'>" + booth.name + "<br/></div>"
                    + "</div></div>";

                return markup;
            }

            function formatTemplateUser(user) {
                if (user.loading) return user.text;
                if (!user.name) return null;

                var markup = "<div class='container' style='width: 100%'><div class='row'>"
                    + "<div class='col-md-1'><img src='" + user.gravatar + "' /></div>"
                    + "<div class='col-md-11'>" + user.name + "<br/><small>" + user.email + "</small></div>"
                    + "</div></div>";

                return markup;
            }

            function formatTemplateSelection(item) {
                return item.name || item.text;
            }

            var $boothSelect = $('#booth_id');
            var selectedBooth = {!! isset($club) ? $club->booths->pluck('name','id')->toJson() : '{}' !!};
            var selectedBoothIds = {!! isset($club) ? $club->booths->pluck('id')->toJson() : '{}' !!};
            var initialBooths = [];
            $.each(selectedBooth, function (key, val) {
                initialBooths.push({id: key, text: val});
            });
            $boothSelect.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                data: initialBooths,
                ajax: {
                    url: '{{ route('api.booth-list') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': window.Laravel.csrfToken,
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            club: {{ $club->id ?? 0 }}
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 10) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: formatTemplateBooth, // omitted for brevity, see the source of this page
                templateSelection: formatTemplateSelection // omitted for brevity, see the source of this page
            });
            $boothSelect.val(selectedBoothIds).trigger('change');

            var $userSelect = $('#user_id');
            var selectedUser = {!! isset($club) ? $club->users->pluck('name','id')->toJson() : '{}' !!};
            var selectedUserIds = {!! isset($club) ? $club->users->pluck('id')->toJson() : '{}' !!};
            var initialUsers = [];
            $.each(selectedUser, function (key, val) {
                initialUsers.push({id: key, text: val});
            });
            $userSelect.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                data: initialUsers,
                ajax: {
                    url: '{{ route('api.user-list') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': window.Laravel.csrfToken,
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            club: {{ $club->id ?? 0 }}
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 10) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                templateResult: formatTemplateUser, // omitted for brevity, see the source of this page
                templateSelection: formatTemplateSelection // omitted for brevity, see the source of this page
            });
            $userSelect.val(selectedUserIds).trigger('change');
        });
    </script>
@endsection
