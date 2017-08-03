<div class="card">
    <div class="card-header">
        打卡紀錄
    </div>
    <ul class="list-group list-group-flush">
        @forelse($records as $record)
            <li class="list-group-item">
                <div>
                    {!! $record->club->clubType->tag ?? '' !!}
                    {{ $record->club->name }}
                    @if(!$record->club->is_counted)
                        <span class='badge badge-default tag'>無法集點</span>
                    @endif
                    <br/>
                    <small>
                        {{ $record->created_at }}
                        （{{ (new \Carbon\Carbon($record->created_at))->diffForHumans() }}）
                    </small>
                </div>
            </li>
        @empty
            <li class="list-group-item">
                <div>
                    尚無打卡紀錄
                </div>
            </li>
        @endforelse
    </ul>
</div>
