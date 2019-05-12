@extends('layouts.base')

@section('title', '迎新茶會')


@section('main_content')
    <div class="card">
        <div class="card-body">
            <div class="container py-2">
                @foreach($teaParties as $teaParty)
                    <div class="row">
                        {{-- timeline item left dot --}}
                        <div class="col-auto text-center flex-column d-none d-sm-flex">
                            <div class="row h-50">
                                @if($loop->first)
                                    <div class="col">&nbsp;</div>
                                @else
                                    <div class="col border-right">&nbsp;</div>
                                @endif
                                <div class="col">&nbsp;</div>
                            </div>
                            <h5 class="m-2">
                                <span
                                    class="badge badge-pill @if(!$teaParty->is_started) bg-success @else bg-light border @endif">&nbsp;</span>
                            </h5>
                            <div class="row h-50">
                                @if($loop->last)
                                    <div class="col">&nbsp;</div>
                                @else
                                    <div class="col border-right">&nbsp;</div>
                                @endif
                                <div class="col">&nbsp;</div>
                            </div>
                        </div>
                        {{-- timeline item event content --}}
                        <div class="col py-2">
                            <div class="card @if(!$teaParty->is_started) border-success shadow @endif">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex flex-column flex-md-row">
                                        <h4 class="card-title">
                                            @if($teaParty->url)
                                                <a href="{{ $teaParty->url }}" target="_blank">
                                                    {{ $teaParty->name }}<i class="fas fa-external-link-alt ml-2"></i>
                                                </a>
                                            @else
                                                {{ $teaParty->name }}
                                            @endif
                                        </h4>
                                        <div class="ml-md-auto">
                                            {!! $teaParty->club->clubType->tag !!}{{ $teaParty->club->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-md-row">
                                        <div class="text-muted mx-1">
                                            <i class="fas fa-clock"></i>
                                            {{ $teaParty->start_at->format('Y-m-d H:i') }}
                                            @if($teaParty->start_at->notEqualTo($teaParty->end_at))
                                                ~
                                                {{ $teaParty->end_at->format('Y-m-d H:i') }}
                                            @endif
                                        </div>
                                        <div class="text-muted mx-1">
                                            <i class="fas fa-map-marked-alt"></i>
                                            {{ $teaParty->location }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
