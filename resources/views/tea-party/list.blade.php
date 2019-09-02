@extends('layouts.base')

@section('title', '迎新茶會')


@section('main_content')
    <div class="card">
        <div class="card-header">近期活動</div>
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
    <div class="card mt-2">
        <div class="card-header">進行中</div>
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
        <div class="card mt-2">
            <div class="card-header">已結束</div>
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
