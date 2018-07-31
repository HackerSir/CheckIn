@extends('layouts.app')

@section('title', $booth->name . ' - 攤位')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('booth.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 攤位管理
            </a>
            <h1>{{ $booth->name }} - 攤位</h1>
            <div class="card">
                <div class="card-body">
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-sm-3">攤位編號</dt>
                        <dd class="col-sm-9">{{ $booth->name }}</dd>

                        <dt class="col-sm-3">社團</dt>
                        <dd class="col-sm-9">
                            @if($booth->club)
                                <a href="{{ route('clubs.show', $booth->club) }}">
                                    {!! $booth->club->display_name !!}
                                </a>
                            @endif
                        </dd>

                        <dt class="col-sm-3">經緯度</dt>
                        <dd class="col-sm-9">{{ $booth->latitude }}, {{ $booth->longitude }}</dd>
                    </dl>

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                                frameborder="0" style="border:0"
                                src="{{ $booth->embed_map_url }}"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
                <div class="card-body">
                    <a href="{{ route('booth.edit', $booth) }}" class="btn btn-primary">
                        <i class="fa fa-edit" aria-hidden="true"></i> 編輯資料
                    </a>
                    {!! Form::open(['route' => ['booth.destroy', $booth], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-times" aria-hidden="true"></i> 刪除攤位
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
