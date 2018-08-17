<div class="row">
    <div class="col">
        <dl class="row">
            <dt class="col-4 col-md-3">社團</dt>
            <dd class="col-8 col-md-9">
                <a href="{{ route('clubs.show', $dataUpdateRequest->club) }}">
                    {!! $dataUpdateRequest->club->display_name !!}
                </a>
            </dd>
            <dt class="col-4 col-md-3">申請者</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->user->display_name }}</dd>
            <dt class="col-4 col-md-3">申請原因</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->reason }}</dd>
            <dt class="col-4 col-md-3">申請時間</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->submit_at }}</dd>
        </dl>
    </div>
    <div class="col">
        <dl class="row">
            <dt class="col-4 col-md-3">審核結果</dt>
            <dd class="col-8 col-md-9">{!! $dataUpdateRequest->show_result !!}</dd>
            <dt class="col-4 col-md-3">審核者</dt>
            <dd class="col-8 col-md-9">{{ optional($dataUpdateRequest->reviewer)->display_name }}</dd>
            <dt class="col-4 col-md-3">審核評語</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->review_comment }}</dd>
            <dt class="col-4 col-md-3">審核時間</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->review_at }}</dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col">
        <b>原內容</b>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團簡介</span></div>
            <blockquote>
                {!! nl2br(e($dataUpdateRequest->original_description)) !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">額外資訊</span></div>
            <blockquote>
                {!! nl2br(e($dataUpdateRequest->original_extra_info)) !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團網址</span></div>
            {{ link_to($dataUpdateRequest->original_url, $dataUpdateRequest->original_url, ['target' => '_blank']) }}
        </div>
    </div>
    <div class="col">
        <b>新內容</b>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團簡介</span></div>
            <blockquote>
                {!! nl2br(e($dataUpdateRequest->description)) !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">額外資訊</span></div>
            <blockquote>
                {!! nl2br(e($dataUpdateRequest->extra_info)) !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團網址</span></div>
            {{ link_to($dataUpdateRequest->url, $dataUpdateRequest->url, ['target' => '_blank']) }}
        </div>
    </div>
</div>
