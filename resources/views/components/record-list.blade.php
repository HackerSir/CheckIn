
<ul class="list-group">
    @forelse($records as $record)
        <li class="list-group-item">
            <div>
                <h4>{{ link_to_route('clubs.show', $record->club->name, $record->club) }}
                    {!! $record->club->clubType->tag ?? '' !!}
                    @if(!$record->club->is_counted)
                        <span class='badge badge-default'>不列入集點</span>
                    @endif
                </h4>
                <small>
                    {{ $record->created_at }}
                    （{{ (new \Carbon\Carbon($record->created_at))->diffForHumans() }}）
                </small>
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
