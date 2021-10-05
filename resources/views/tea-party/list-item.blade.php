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
                <div class="d-flex flex-column flex-md-row flex-wrap">
                    <h4 class="card-title">
                        @if($teaParty->url)
                            <a href="{{ $teaParty->url }}" target="_blank" rel="noopener noreferrer">
                                {{ $teaParty->name }}<i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        @else
                            {{ $teaParty->name }}
                        @endif
                    </h4>
                    <div class="ml-md-auto">
                        @if($teaParty->club->clubType)
                            {!! $teaParty->club->clubType->tag !!}
                        @endif
                        <a href="{{ route('clubs.show', $teaParty->club) }}">{!! $teaParty->club->name !!}</a>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row flex-wrap">
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
                    <div class="text-muted mx-1 ml-auto">
                        @if($teaParty->google_event_url)
                            <a href="{{ $teaParty->google_event_url }}" class="btn btn-outline-info btn-sm"
                               target="_blank"><i class="fab fa-google mr-2"></i>在 Google 日曆查看</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
