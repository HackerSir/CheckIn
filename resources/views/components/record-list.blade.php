<ul class="list-group">
    @forelse($student->records as $record)
        <li class="list-group-item d-flex flex-column flex-md-row">
            <div>
                <h4 class="mb-1">{{ link_to_route('clubs.show', $record->club->name, $record->club) }}
                    {!! $record->club->clubType->tag ?? '' !!}
                    @if(!$record->club->is_counted)
                        <span class='badge badge-secondary'>不列入集點</span>
                    @endif
                </h4>
                <div class="text-muted d-flex flex-wrap">
                    <div title="{{ $record->created_at }}" class="d-inline-block mr-2">
                        <i class="fas fa-clock mr-1"></i>{{ (new \Carbon\Carbon($record->created_at))->diffForHumans() }}
                    </div>
                    @if($booth = $record->club->booths->first())
                        <div class="d-inline-block">
                            <i class="fas fa-store"></i>
                            @if($booth->zone)
                                <span class="badge badge-secondary">{{ $booth->zone }}</span>
                            @endif
                            {{ $booth->name }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="ml-md-auto align-self-center">
                @if($feedbackItem = $feedback->get($record->club->id))
                    <a href="{{ route('feedback.show', $feedbackItem) }}" class="btn btn-success">
                        <i class="fa fa-search"></i> 檢視回饋資料
                    </a>
                @endif
            </div>
        </li>
    @empty
        <li class="list-group-item">
            <div>
                尚無打卡紀錄，快去打卡吧
            </div>
        </li>
    @endforelse
</ul>
