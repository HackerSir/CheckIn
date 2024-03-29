@extends('layouts.base')

@section('title', $teaParty->club->name . ' - 迎新茶會')

@section('buttons')
    <a href="{{ route('tea-party.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>迎新茶會管理
    </a>
    <a href="{{ route('clubs.show', $teaParty->club) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>檢視社團
    </a>
    <a href="{{ route('tea-party.edit', $teaParty) }}" class="btn btn-primary">
        <i class="fa fa-edit mr-2"></i>編輯
    </a>
    {!! Form::open(['route' => ['tea-party.destroy', $teaParty], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash mr-2"></i>刪除
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-4 col-md-2">社團</dt>
                <dd class="col-8 col-md-10">
                    <a href="{{ route('clubs.show', $teaParty->club) }}">{!! $teaParty->club->display_name !!}</a>
                </dd>

                <dt class="col-4 col-md-2">茶會名稱</dt>
                <dd class="col-8 col-md-10">
                    {{ $teaParty->name }}
                    @if($teaParty->google_event_url)
                        <a href="{{ $teaParty->google_event_url }}" class="btn btn-outline-info btn-sm" target="_blank"><i
                                class="fab fa-google mr-2"></i>在 Google 日曆查看</a>
                    @endif
                </dd>

                <dt class="col-4 col-md-2">開始時間</dt>
                <dd class="col-8 col-md-10">{{ $teaParty->start_at }}</dd>

                <dt class="col-4 col-md-2">結束時間</dt>
                <dd class="col-8 col-md-10">{{ $teaParty->end_at }}</dd>

                <dt class="col-4 col-md-2">地點</dt>
                <dd class="col-8 col-md-10">{{ $teaParty->location }}</dd>

                <dt class="col-4 col-md-2">網址</dt>
                <dd class="col-8 col-md-10">
                    @if($teaParty->url)
                        <a href="{{ $teaParty->url }}" target="_blank"
                           rel="noopener noreferrer">{{ $teaParty->url }}</a>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
