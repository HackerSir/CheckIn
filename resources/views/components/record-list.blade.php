<ul class="list-group">
    @forelse($student->records as $record)
        <li class="list-group-item clearfix">
            <h4 class="mb-1">{{ link_to_route('clubs.show', $record->club->name, $record->club) }}
                {!! $record->club->clubType->tag ?? '' !!}
                @if(!$record->club->is_counted)
                    <span class='badge badge-secondary'>不列入集點</span>
                @endif
            </h4>
            <p>
                <span title="{{ $record->created_at }}">
                    {{ (new \Carbon\Carbon($record->created_at))->diffForHumans() }}
                </span>
            </p>
        </li>
    @empty
        <li class="list-group-item">
            <div>
                尚無打卡紀錄，快去打卡吧
            </div>
        </li>
    @endforelse
</ul>
