@extends('layouts.app')

@section('title', $club->name)

@section('content')
    <div class="mt-3 pb-3">
        <div class="mb-2">
            @if(\Laratrust::can('club.manage'))
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
            @elseif(isset(Auth::user()->club) && Auth::user()->club->id == $club->id)
                <a href="{{ route('own-club.edit') }}" class="btn btn-primary">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 編輯資料
                </a>
            @endif
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
                            <dt class="col-4 col-sm-3">社團編號</dt>
                            <dd class="col-8 col-sm-9">{{ $club->number }}</dd>

                            <dt class="col-4 col-sm-3">社團類型</dt>
                            <dd class="col-8 col-sm-9">{!! $club->clubType->tag ?? '' !!}</dd>

                            <dt class="col-4 col-sm-3">可否集點</dt>
                            <dd class="col-8 col-sm-9">
                                @if($club->is_counted)
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-square-o" aria-hidden="true"></i>
                                @endif
                            </dd>

                            <dt class="col-sm-3">網站</dt>
                            <dd class="col-sm-9">
                                @if($club->url)
                                    {{ link_to($club->url, $club->url, ['target' => '_blank']) }}
                                @endif
                            </dd>

                            @if(\Laratrust::can('club.manage') || (isset(Auth::user()->club) && Auth::user()->club->id == $club->id))
                                <dt class="col-4 col-sm-3">負責人</dt>
                                <dd class="col-8 col-sm-9">
                                    @foreach($club->users as $user)
                                        {{ $user->name }}<br/>
                                    @endforeach
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
                <div class="mt-2">
                    <h2>簡介</h2>
                    <p style="font-size: 120%">{!! nl2br(e($club->description)) !!}</p>
                </div>
                <div class="mt-2">
                    <h2>攤位</h2>
                    <div class="row">
                        @foreach($club->booths as $booth)
                            <div class="col-md">
                                @if(\Laratrust::can('booth.manage'))
                                    <h3>{{ link_to_route('booth.show', $booth->name, $booth) }}</h3>
                                @else
                                    <h3>{{ $booth->name }}</h3>
                                @endif

                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item"
                                            frameborder="0" style="border:0"
                                            src="{{ $booth->embed_map_url }}"
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                            {{-- 每兩個就插入，強制換行 --}}
                            @if ($loop->index % 2 == 1)
                                <div class="w-100"></div>
                            @endif
                            {{-- 若最後一行不足兩個，就多加一個空的 div --}}
                            @if ($loop->last && $loop->count > 2 && $loop->count % 2 != 0)
                                <div class="col-md"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
@endsection
