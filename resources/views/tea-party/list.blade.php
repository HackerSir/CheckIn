@extends('layouts.base')

@section('title', '迎新茶會')

@section('main_content')
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
