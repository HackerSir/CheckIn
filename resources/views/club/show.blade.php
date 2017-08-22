@extends('layouts.app')

@section('title', $club->name)

@section('content')
    <div class="mt-3 pb-3">
        <div class="mb-2">
            <a href="{{ route('club.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團管理
            </a>
            <a href="{{ route('club.edit', $club) }}" class="btn btn-primary">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 編輯資料
            </a>
            {!! Form::open(['route' => ['club.destroy', $club], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-trash" aria-hidden="true"></i> 刪除社團
            </button>
            {!! Form::close() !!}
        </div>
        <div class="card">
            <div class="card-block">
                <h1>{{ $club->name }}</h1>
                <div class="row">
                    <div class="col-12 col-lg-5 mt-1">
                        @if($club->imgurImage)
                            <img src="{{ $club->imgurImage->thumbnail('l') }}" class="img-fluid">
                        @else
                            <img data-src="holder.js/400x300?random=yes&auto=yes&text=沒有圖片" class="img-fluid">
                        @endif
                    </div>
                    <div class="col-12 col-lg-7 mt-1">
                        <dl class="row" style="font-size: 120%">
                            <dt class="col-sm-3">社團編號</dt>
                            <dd class="col-sm-9">{{ $club->number }}</dd>

                            <dt class="col-sm-3">社團類型</dt>
                            <dd class="col-sm-9">{!! $club->clubType->tag ?? '' !!}</dd>

                            <dt class="col-sm-3">可否集點</dt>
                            <dd class="col-sm-9">
                                @if($club->is_counted)
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-square-o" aria-hidden="true"></i>
                                @endif
                            </dd>

                            <dt class="col-sm-3">攤位</dt>
                            <dd class="col-sm-9">
                                @foreach($club->booths as $booth)
                                    {{ link_to_route('booth.show', $booth->name, $booth) }}<br/>
                                @endforeach
                            </dd>

                            <dt class="col-sm-3">網站</dt>
                            <dd class="col-sm-9">
                                @if($club->url)
                                    {{ link_to($club->url, $club->url, ['target' => '_blank']) }}
                                @endif
                            </dd>

                            <dt class="col-sm-3">負責人</dt>
                            <dd class="col-sm-9">
                                @foreach($club->users as $user)
                                    {{ $user->name }}<br/>
                                @endforeach
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-2">
                    <h2>簡介</h2>
                    <p style="font-size: 120%">{!! nl2br(e($club->description)) !!}</p>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
@endsection
