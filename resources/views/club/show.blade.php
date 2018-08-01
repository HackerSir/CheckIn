@extends('layouts.base')

@section('title', $club->name)

@if($club->imgurImage)
    @section('og_image', $club->imgurImage->thumbnail('l'))
@endif

@section('buttons')
    <a href="{{ route('clubs.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團攤位
    </a>
    @if(\Laratrust::can('club.manage'))
        <a href="{{ route('club.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團管理
        </a>
        <a href="{{ route('club.edit', $club) }}" class="btn btn-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> 編輯資料
        </a>
        {!! Form::open(['route' => ['club.destroy', $club], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-trash" aria-hidden="true"></i> 刪除社團
        </button>
        {!! Form::close() !!}
    @elseif(isset(Auth::user()->club) && Auth::user()->club->id == $club->id)
        <a href="{{ route('own-club.edit') }}" class="btn btn-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> 編輯資料
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-5 mt-1">
                    @if($club->imgurImage)
                        <img src="{{ $club->imgurImage->thumbnail('l') }}" class="img-fluid">
                    @else
                        <img src="" data-src="holder.js/400x300?random=yes&auto=yes&text=沒有圖片" class="img-fluid">
                    @endif
                </div>
                <div class="col-12 col-lg-7 mt-1">
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-6 col-sm-3">社團編號</dt>
                        <dd class="col-6 col-sm-9">{{ $club->number }}</dd>

                        <dt class="col-6 col-sm-3">社團類型</dt>
                        <dd class="col-6 col-sm-9">
                            @if($club->clubType)
                                {!! $club->clubType->tag !!}
                            @else
                                <span class="text-muted">（其他／未分類）</span>
                            @endif
                        </dd>

                        <dt class="col-6 col-sm-3">可否集點</dt>
                        <dd class="col-6 col-sm-9">
                            @if($club->is_counted)
                                <span class="text-success">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> 列入集點
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="fa fa-square-o" aria-hidden="true"></i> 不列入集點
                                </span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">網址</dt>
                        <dd class="col-sm-9">
                            @if($club->url)
                                <p style="word-break: break-all;">
                                    {{ link_to($club->url, $club->url, ['target' => '_blank']) }}
                                </p>
                            @else
                                <span class="text-muted">（無）</span>
                            @endif
                        </dd>

                        @if(\Laratrust::can('club.manage') || (isset(Auth::user()->club) && Auth::user()->club->id == $club->id))
                            <dt class="col-6 col-sm-3">負責人</dt>
                            <dd class="col-6 col-sm-9">
                                @forelse($club->users as $user)
                                    @if(Laratrust::can('user.manage'))
                                        {{ link_to_route('user.show', $user->name, $user) }}
                                    @else
                                        {{ $user->name }}
                                    @endif
                                    <br/>
                                @empty
                                    <span class="text-muted">（無）</span>
                                @endforelse
                            </dd>
                        @endif

                        <dt class="col-sm-3">回饋資料</dt>
                        <dd class="col-sm-9">
                            <small class="form-text text-muted">
                                若對此社團感興趣，歡迎填寫回饋資料
                            </small>
                            @if(!Auth::check())
                                <a href="javascript:void(0)" class="btn btn-primary btn-lg disabled">
                                    <i class="fa fa-times" aria-hidden="true"></i> 登入後即可填寫
                                </a>
                            @elseif(Auth::user()->student)
                                @if(\App\Feedback::whereClubId($club->id)->whereStudentId(Auth::user()->student->id)->count() == 0)
                                    <a href="{{ route('feedback.create', $club) }}" class="btn btn-primary btn-lg">
                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i> 按此填寫
                                    </a>
                                @else
                                    <a href="{{ route('feedback.create', $club) }}" class="btn btn-success btn-lg">
                                        <i class="fa fa-check" aria-hidden="true"></i> 已填寫完成
                                    </a>
                                @endif
                            @else
                                <a href="javascript:void(0)" class="btn btn-primary btn-lg disabled">
                                    <i class="fa fa-times" aria-hidden="true"></i> 限學生帳號使用
                                </a>
                            @endif
                            @php
                                $feedbackCreateExpiredAt = new \Carbon\Carbon(Setting::get('feedback_create_expired_at'));
                            @endphp
                            <small class="form-text text-muted">
                                填寫截止時間：
                                {{ $feedbackCreateExpiredAt }}（{{ $feedbackCreateExpiredAt->diffForHumans() }}）
                            </small>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="mt-2">
                <h2>簡介</h2>
                <p style="font-size: 120%">
                    @if($club->description)
                        {!! nl2br(e($club->description)) !!}
                    @else
                        <span class="text-muted">（未提供簡介）</span>
                    @endif
                </p>
            </div>
            <div class="mt-2">
                <h2>攤位</h2>
                <div class="row">
                    @forelse($club->booths as $booth)
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
                    @empty
                        <div class="col-md">
                            <span class="text-muted">（無）</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
@endsection
