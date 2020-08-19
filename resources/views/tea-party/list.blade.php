@extends('layouts.base')

@section('title', '迎新茶會')

@section('main_content')
    <div class="d-flex">
        <div class="btn-group my-1" role="group">
            <a href="{{ rtrim(request()->fullUrlWithQuery(['type' => null]), '?') }}"
               class="btn btn-secondary @if (!request('type')) active @endif">全部</a>
            <a href="{{ request()->fullUrlWithQuery(['type' => 'favorite']) }}"
               class="btn btn-secondary @if (request('type') == 'favorite') active @endif">收藏社團</a>
            <a href="{{ request()->fullUrlWithQuery(['type' => 'join']) }}"
               class="btn btn-secondary @if (request('type') == 'join') active @endif">考慮或已登記參加茶會</a>
        </div>
        <div class="ml-auto">
            <form action="{{ url()->current() }}" method="get" class="form-inline">
                <div class="input-group is-invalid">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                    <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="搜尋"
                           required>
                    <div class="input-group-append">
                        @if(request('q'))
                            <a href="{{ rtrim(request()->fullUrlWithQuery(['q' => null]), '?') }}"
                               class="btn btn-secondary"><i class="fas fa-eraser"></i></a>
                        @endif
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($inProcessTeaPartyCount = count($teaParties['in_process'] ?? [])>0)
        <div class="alert alert-info">
            目前有 {{ $inProcessTeaPartyCount }} 場活動正在進行中
            <a href="javascript:void(0)" id="jumpToInProcessTeaParty"><strong>[按此查看]</strong></a>
        </div>
    @endif
    <div class="card" id="notStartedTeaParty">
        <div class="card-header d-flex">
            近期活動
        </div>
        <div class="card-body">
            <div class="container py-2">
                @forelse($teaParties['not_started'] ?? [] as $teaParty)
                    @include('tea-party.list-item')
                @empty
                    <div class="text-center text-muted">暫無相關資訊</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="card mt-2" id="inProcessTeaParty">
        <div class="card-header d-flex">
            進行中
            <a href="javascript:void(0)" class="ml-auto jumpToTop" title="回到最上方"><i
                    class="fas fa-arrow-alt-circle-up mr-1"></i>TOP</a></div>
        <div class="card-body">
            <div class="container py-2">
                @forelse($teaParties['in_process'] ?? [] as $teaParty)
                    @include('tea-party.list-item')
                @empty
                    <div class="text-center text-muted">目前無進行中活動</div>
                @endforelse
            </div>
        </div>
    </div>
    @if(count($teaParties['ended'] ?? []))
        <div class="card mt-2" id="endedTeaParty">
            <div class="card-header d-flex">
                已結束
                <a href="javascript:void(0)" class="ml-auto jumpToTop" title="回到最上方"><i
                        class="fas fa-arrow-alt-circle-up mr-1"></i>TOP</a>
            </div>
            <div class="card-body">
                <div class="container py-2">
                    @foreach($teaParties['ended'] ?? [] as $teaParty)
                        @include('tea-party.list-item')
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script>
        $('#jumpToInProcessTeaParty').on('click', function () {
            window.scrollTo({
                top: $('#inProcessTeaParty').offset().top - 60,
                behavior: 'smooth'
            });
        });
        $('.jumpToTop').on('click', function () {
            $('body')[0].scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
@endsection
