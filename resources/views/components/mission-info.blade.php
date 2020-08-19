@if(isset($student->ticket))
    <div class="alert alert-success text-center">
        <i class="fas fa-ticket-alt mr-2"></i>抽獎編號<i class="fas fa-ticket-alt ml-2"></i>
        <h3>{{ sprintf("%04d", $student->ticket->id) }}</h3>
        <span class="text-danger">任務已完成</span>
    </div>
@else
    @if(!$student->is_freshman)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle mr-2"></i>抽獎活動限<strong>大學部新生</strong>參加，即使完成任務，也無法參加抽獎
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-exclamation-triangle mr-2"></i>完成以下任務，即可取得抽獎編號
        </div>
    @endif
@endif
<dl class="row" style="font-size: 120%">
    <dt class="col-md-3 col-lg-2">打卡集點</dt>
    <dd class="col-md-7 col-lg-10">
        @php
            $progress = ($student->countedRecords->count() / \Setting::get('target')) * 100;
            $progress = round($progress, 2);
        @endphp
        @if($student->has_enough_counted_records)
            <span class="text-success"><i class="far fa-check-square mr-2"></i>已完成</span>
        @else
            <span class="text-danger"><i class="far fa-square mr-2"></i>未完成</span>
        @endif
        <div class="d-inline-block">（{{ $student->countedRecords->count() }} / {{ \Setting::get('target') }}）</div>
        @if($student->has_enough_counted_records)
            @include('components.progress-bar', ['progress' => $progress, 'bgClass' => 'bg-success'])
        @else
            @include('components.progress-bar', ['progress' => $progress, 'bgClass' => 'bg-danger'])
        @endif
    </dd>
    <dt class="col-md-3 col-lg-2">區域收集</dt>
    <dd class="col-md-7 col-lg-10">
        @php
            $progress = ($student->zones_of_counted_records->count() / \Setting::get('zone_target')) * 100;
            $progress = round($progress, 2);
        @endphp
        @if($student->has_enough_zones_of_counted_records)
            <span class="text-success"><i class="far fa-check-square mr-2"></i>已完成</span>
        @else
            <span class="text-danger"><i class="far fa-square mr-2"></i>未完成</span>
        @endif
        <div class="d-inline-block">（{{ $student->zones_of_counted_records->count() }}
            / {{ \Setting::get('zone_target') }}）
        </div>
        @if($student->has_enough_zones_of_counted_records)
            @include('components.progress-bar', ['progress' => $progress, 'bgClass' => 'bg-success'])
        @else
            @include('components.progress-bar', ['progress' => $progress, 'bgClass' => 'bg-danger'])
        @endif
    </dd>
    <dt class="col-md-3 col-lg-2">填寫平台問卷</dt>
    <dd class="col-md-7 col-lg-10">
        <div class="mb-2">
            @if($student->studentSurvey)
                <span class="text-success">
                    <i class="far fa-check-square mr-2"></i>已完成
                </span>
                @include('components.progress-bar', ['progress' => 100, 'bgClass' => 'bg-success'])
            @else
                <span class="text-danger">
                    <i class="far fa-square mr-2"></i>未完成
                </span>
                @if($showSurveyButton ?? false)
                    @if($student->studentSurvey)
                        <div class="d-inline-block">
                            <a href="{{ route('survey.student.show') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-search mr-2"></i>檢視平台問卷
                            </a>
                        </div>
                    @elseif(Carbon\Carbon::now()->gt(new Carbon\Carbon(Setting::get('end_at'))))
                        <div class="d-inline-block">
                            <button type="button" class="btn btn-primary btn-sm disabled">
                                <i class="fa fa-edit mr-2"></i>填寫平台問卷
                            </button>
                            <small class="text-danger">已超過填寫時間</small>
                        </div>
                    @elseif(!$student->has_enough_counted_records)
                        <div class="d-inline-block">
                            <button type="button" class="btn btn-primary btn-sm disabled">
                                <i class="fa fa-edit mr-2"></i>填寫平台問卷
                            </button>
                            <small class="text-danger">請先完成<strong>打卡集點</strong></small>
                        </div>
                    @else
                        <div class="d-inline-block">
                            <a href="{{ route('survey.student.edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit mr-2"></i>填寫平台問卷
                            </a>
                        </div>
                    @endif
                @endif
                @include('components.progress-bar', ['progress' => 0, 'bgClass' => 'bg-danger'])
            @endif
        </div>
    </dd>
</dl>
