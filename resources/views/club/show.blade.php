@extends('layouts.base')

@inject('contentPresenter', 'App\Presenters\ContentPresenter')

@section('title', $club->name)

@php
    $feedback = \App\Feedback::whereClubId($club->id)->whereStudentNid(Auth::user()->student->nid ?? null)->first();
@endphp

@if($club->imgurImage)
    @section('og_image', $club->imgurImage->thumbnail('l'))
@endif

@section('buttons')
    <a href="{{ route('clubs.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>社團攤位
    </a>
    @if(\Laratrust::can('club.manage'))
        <a href="{{ route('club.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left mr-2"></i>社團管理
        </a>
        <a href="{{ route('club.edit', $club) }}" class="btn btn-primary">
            <i class="fa fa-edit mr-2"></i>編輯資料
        </a>
        {!! Form::open(['route' => ['club.destroy', $club], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-trash mr-2"></i>刪除社團
        </button>
        {!! Form::close() !!}
    @elseif(Gate::allows('as-staff', $club))
        @if(Carbon\Carbon::now()->lte(new Carbon\Carbon(Setting::get('club_edit_deadline'))))
            <a href="{{ route('own-club.edit') }}" class="btn btn-primary">
                <i class="fa fa-edit mr-2"></i>編輯資料
            </a>
        @else
            {{--            <button class="btn btn-primary disabled" onclick="alert('已超過資料編輯期限，請提交社團資料修改申請')">--}}
            {{--                <i class="fa fa-edit mr-2"></i>編輯資料--}}
            {{--            </button>--}}
            <a href="{{ route('own-club.data-update-request.index') }}" class="btn btn-primary">
                <i class="fa fa-edit mr-2"></i>社團資料修改申請
            </a>
        @endif
    @endif
    @auth
        <favorite-club-button favorited="{{ auth()->user()->isFavoriteClub($club) }}" :club-id="{{ $club->id }}"
                              club-name="{{ $club->name }}"></favorite-club-button>
    @endauth
    @if(config('app.open_beta'))
        {!! Form::open(['route' => ['open-beta.promote-to-staff', $club], 'style' => 'display: inline', 'onSubmit' => "return confirm('此為測試限定功能，確定要成為該社團工作人員嗎？');"]) !!}
        <button type="submit" class="btn btn-danger"
                style="background: repeating-linear-gradient(-45deg,#dc3545,#dc3545 10px,#d9828a 10px,#d9828a 20px)">
            <i class="fa fa-user-secret mr-2"></i>成為工作人員
        </button>
        {!! Form::close() !!}
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
                                    <i class="far fa-check-square mr-2"></i>列入集點
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="far fa-square mr-2"></i>不列入集點
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

                        @can('as-staff', $club)
                            <dt class="col-6 col-sm-3 text-muted">社長<i class="fas fa-eye-slash ml-2"
                                                                       title="僅工作人員可見"></i></dt>
                            <dd class="col-6 col-sm-9">
                                @php
                                    $leader = $club->leaders()->first();
                                @endphp
                                @if($leader)
                                    @if(Laratrust::can('student.manage'))
                                        {{ link_to_route('student.show', $leader->name, $leader) }}
                                    @else
                                        {{ $leader->name  }}
                                    @endif
                                @else
                                    <span class="text-muted">（無）</span>
                                @endif
                            </dd>
                            <dt class="col-6 col-sm-3 text-muted">工作人員<i class="fas fa-eye-slash ml-2"
                                                                         title="僅工作人員可見"></i></dt>
                            <dd class="col-6 col-sm-9">
                                @forelse($club->staffs as $staff)
                                    @if(Laratrust::can('student.manage'))
                                        {{ link_to_route('student.show', $staff->name, $staff) }}
                                    @else
                                        {{ $staff->name }}
                                    @endif
                                    <br/>
                                @empty
                                    <span class="text-muted">（無）</span>
                                @endforelse
                            </dd>
                            <dt class="col-6 col-sm-3 text-muted">自訂問題<i class="fas fa-eye-slash ml-2"
                                                                         title="僅工作人員可見"></i></dt>
                            <dd class="col-6 col-sm-9">
                                {{ $club->custom_question }}
                            </dd>
                        @endcan

                        <dt class="col-sm-3">回饋資料</dt>
                        <dd class="col-sm-9">
                            <small class="form-text text-muted">
                                若對此社團感興趣，歡迎填寫回饋資料
                            </small>
                            @if(!Auth::check())
                                <a href="javascript:void(0)" class="btn btn-primary btn-lg disabled">
                                    <i class="fa fa-pencil-alt mr-2"></i>登入後即可填寫
                                </a>
                            @elseif(Auth::user()->student)
                                @if(!$feedback)
                                    <a href="{{ route('feedback.create', $club) }}" class="btn btn-primary btn-lg">
                                        <i class="fa fa-pencil-alt mr-2"></i>按此填寫
                                    </a>
                                @else
                                    <a href="{{ route('feedback.create', $club) }}" class="btn btn-success btn-lg">
                                        <i class="fa fa-check mr-2"></i>已填寫完成
                                    </a>
                                @endif
                            @else
                                <a href="javascript:void(0)" class="btn btn-primary btn-lg disabled">
                                    <i class="fa fa-times mr-2"></i>限學生帳號使用
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
                <h2 class="border border-primary rounded"><i class="fas fa-newspaper mx-2"></i>簡介</h2>
                <p style="font-size: 120%">
                    @if($club->description)
                        {!! $club->description !!}
                    @else
                        <span class="text-muted">（未提供簡介）</span>
                    @endif
                </p>
            </div>
            @if($club->extra_info)
                <div class="mt-2">
                    <h2 class="border border-primary rounded"><i class="fas fa-info-circle mx-2"></i>額外資訊</h2>
                    <p style="font-size: 120%">
                    @if(\Laratrust::can('club.manage') || Gate::allows('as-staff', $club) || $feedback)
                        {{--                            {!! $contentPresenter->showContent($club->extra_info) !!}--}}
                        {!! $club->extra_info !!}
                    @else
                        <div class="alert alert-warning">此社團有提供額外資訊給感興趣加入的學生，填寫回饋資料後即可檢視</div>
                        @endif
                        </p>
                </div>
            @endif
            <div class="mt-2">
                <h2 class="border border-primary rounded">
                    <i class="fas fa-mug-hot mx-2"></i>迎新茶會
                    @if(Laratrust::can('tea-party.manage'))
                        @if($club->teaParty)
                            <div style="display: inline-block">
                                <a href="{{ route('tea-party.edit', $club->teaParty) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit mr-2"></i>編輯
                                </a>
                            </div>
                            {!! Form::open(['route' => ['tea-party.destroy', $club->teaParty], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash mr-2"></i>刪除
                            </button>
                            {!! Form::close() !!}
                        @else
                            <a href="{{ route('tea-party.create', ['club_id' => $club->id]) }}"
                               class="btn btn-primary btn-sm">
                                <i class="fa fa-plus-circle mr-2"></i>新增迎新茶會
                            </a>
                        @endif
                    @elseif(Gate::allows('as-staff', $club))
                        @if($club->teaParty)
                            <div style="display: inline-block">
                                <a href="{{ route('own-club.edit-tea-party') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit mr-2"></i>編輯
                                </a>
                            </div>
                            {!! Form::open(['route' => ['own-club.destroy-tea-party'], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash mr-2"></i>刪除
                            </button>
                            {!! Form::close() !!}
                        @else
                            <a href="{{ route('own-club.edit-tea-party') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus-circle mr-2"></i>新增迎新茶會
                            </a>
                        @endif
                    @endif
                </h2>
                <p style="font-size: 120%">
                @if($club->teaParty)
                    <h3><i class="fas fa-mug-hot mr-2"></i>{{ $club->teaParty->name }}</h3>
                    <dl class="row" style="font-size: 120%">
                        <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-clock mr-2"></i>開始時間</dt>
                        <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->start_at }}</dd>

                        <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-clock mr-2"></i>結束時間</dt>
                        <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->end_at }}</dd>

                        <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-map-marked-alt mr-2"></i>地點</dt>
                        <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->location }}</dd>

                        @if($club->teaParty->url)
                            <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-link mr-2"></i>網址</dt>
                            <dd class="col-12 col-sm-8 col-lg-10">
                                <a href="{{ $club->teaParty->url }}" target="_blank">{{ $club->teaParty->url }}</a>
                            </dd>
                        @endif
                    </dl>
                @else
                    <span class="text-muted">（未提供迎新茶會資訊）</span>
                    @endif
                    </p>
            </div>
            <div class="mt-2">
                <h2 class="border border-primary rounded"><i class="fas fa-map-marked-alt mx-2"></i>攤位</h2>
                <div class="row">
                    @forelse($club->booths as $booth)
                        <div class="col-md">
                            <div class="h3">
                                @if($booth->zone)
                                    <span class="badge badge-secondary">{{ $booth->zone }}</span>
                                @endif
                                @if(\Laratrust::can('booth.manage'))
                                    {{ link_to_route('booth.show', $booth->name, $booth) }}
                                @else
                                    {{ $booth->name }}
                                @endif
                            </div>

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
    <script src="{{ asset(mix('/build-js/vue.js')) }}"></script>
@endsection
