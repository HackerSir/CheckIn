@extends('layouts.base')

@section('title', $booth->name . ' - 攤位')

@section('buttons')
    <a href="{{ route('booth.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>攤位管理
    </a>
    <a href="{{ route('booth.edit', $booth) }}" class="btn btn-primary">
        <i class="fa fa-edit mr-2"></i>編輯資料
    </a>
    {!! Form::open(['route' => ['booth.destroy', $booth], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-times mr-2"></i>刪除攤位
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
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
    </div>
@endsection
