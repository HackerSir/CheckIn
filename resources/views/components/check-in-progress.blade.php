@php
    $progress = ($student->countedRecords->count() / \Setting::get('target')) * 100;
    $progress = round($progress, 2);
@endphp
@include('components.progress-bar', compact('progress'))

<dl class="row" style="font-size: 120%">
    <dt class="col-md-2">打卡次數</dt>
    <dd class="col-md-10">{{ $student->records->count() }}</dd>

    <dt class="col-md-2">進度</dt>
    <dd class="col-md-10">{{ $student->countedRecords->count() }}
        / {{ \Setting::get('target') }}</dd>
</dl>
