@for($i = 0; $i < floor($progress / 100); $i++)
    <div class="progress w-80 mb-2">
        <div class="progress-bar d-flex align-items-center justify-content-center"
             role="progressbar" style="width: 100%;">
            <div>{{ $progress }}%</div>
        </div>
    </div>
@endfor
@if($progress == 0 || $progress % 100 > 0)
    <div class="progress w-80 mb-2">
        <div class="progress-bar d-flex align-items-center justify-content-center"
             role="progressbar"
             style="width: {{ $progress % 100 }}%; min-width: 3rem;"
             aria-valuenow="{{ $progress % 100 }}" aria-valuemin="0" aria-valuemax="100">
            <div>{{ $progress }}%</div>
        </div>
    </div>
@endif
