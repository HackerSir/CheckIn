<ul class="list-group">
    @forelse($student->records as $record)
        <li class="list-group-item">
            <div>
                <h4>{{ link_to_route('clubs.show', $record->club->name, $record->club) }}
                    {!! $record->club->clubType->tag ?? '' !!}
                    @if(!$record->club->is_counted)
                        <span class='badge badge-secondary'>不列入集點</span>
                    @endif
                </h4>
                <small>
                    {{ $record->created_at }}
                    （{{ (new \Carbon\Carbon($record->created_at))->diffForHumans() }}）
                </small>
                @if(1)
                    <div class="float-md-right">
                        <button type="button" class="btn btn-success">
                            <i class="fa fa-search"></i> 檢視回饋資料
                        </button>
                    </div>
                @else
                    <div class="float-md-right">
                        <button type="button" class="btn btn-primary">
                            <i class="fa fa-edit"></i> 填寫回饋資料
                        </button>
                    </div>
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
