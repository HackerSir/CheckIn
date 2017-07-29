@extends('layouts.app')

@php
    $isEditMode = isset($club);
    $methodText = $isEditMode ? '編輯' : '新增';
@endphp

@section('title', $methodText . '社團')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $methodText }}社團</h1>
            <div class="card">
                <div class="card-block">
                    @if($isEditMode)
                        {{ Form::model($club, ['route' => ['club.update', $club], 'method' => 'patch']) }}
                    @else
                        {{ Form::open(['route' => 'club.store']) }}
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
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => '如：黑客社']) }}
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

                    <div class="form-group row{{ $errors->has('image_url') ? ' has-danger' : '' }}">
                        <label for="image_url" class="col-md-2 col-form-label">圖片網址</label>
                        <div class="col-md-10">
                            {{ Form::url('image_url', null, ['class' => 'form-control']) }}
                            <small class="form-text text-muted">
                                圖片可上傳至 <a href="https://imgur.com/" target="_blank">Imgur</a> 圖片空間
                            </small>
                            @if ($errors->has('image_url'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('image_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                        <label for="user_id[]" class="col-md-2 col-form-label">社團負責人</label>
                        <div class="col-md-10">
                            {{-- TODO: 預選已存在的社團負責人 --}}
                            {{ Form::select('user_id[]', [], null, ['id' => 'user_id', 'class' => 'form-control', 'multiple']) }}
                            @if ($errors->has('user_id'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary"> 確認</button>
                            @if($isEditMode)
                                <a href="{{ route('club.show', $club) }}" class="btn btn-secondary">返回</a>
                            @else
                                <a href="{{ route('club.index') }}" class="btn btn-secondary">返回列表</a>
                            @endif
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            function formatTemplate(user) {
                if (user.loading) return user.text;
                if (!user.name) return null;

                var markup = "<div class='container' style='width: 100%'><div class='row'>"
                    + "<div class='col-md-1'><img src='" + user.gravatar + "' /></div>"
                    + "<div class='col-md-11'>" + user.name + "<br/><small>" + user.email + "</small></div>"
                    + "</div></div>";

                return markup;
            }

            function formatTemplateSelection(user) {
                return user.name || user.text;
            }

            var $userSelect = $('#user_id');
            var selected = {!!  $club->users->pluck('name','id')->toJson() !!};
            var selectIds = {!!  $club->users->pluck('id')->toJson() !!};
            var initials = [];
            $.each(selected, function (key, val) {
                initials.push({id: key, text: val});
            });
            $userSelect.select2({
                tags: true,
                tokenSeparators: [',', ' '],
                data: initials,
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
                            club: {{ $club->id }}
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
                templateResult: formatTemplate, // omitted for brevity, see the source of this page
                templateSelection: formatTemplateSelection // omitted for brevity, see the source of this page
            });
            $userSelect.val(selectIds).trigger('change');
        });
    </script>
@endsection
