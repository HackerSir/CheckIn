@inject('contentPresenter', 'App\Presenters\ContentPresenter')

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
            <dd class="col-8 col-md-9">
                @if(Laratrust::isAbleTo(['user.manage', 'user.view']))
                    {{ link_to_route('user.show', $dataUpdateRequest->user->display_name, $dataUpdateRequest->user) }}
                @else
                    {{ $dataUpdateRequest->user->display_name }}
                @endif
            </dd>
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
            <dd class="col-8 col-md-9">
                @if($dataUpdateRequest->reviewer)
                    @if(Laratrust::isAbleTo(['user.manage', 'user.view']))
                        {{ link_to_route('user.show', $dataUpdateRequest->reviewer->display_name, $dataUpdateRequest->reviewer) }}
                    @else
                        {{ $dataUpdateRequest->reviewer->display_name }}
                    @endif
                @endif
            </dd>
            <dt class="col-4 col-md-3">審核評語</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->review_comment }}</dd>
            <dt class="col-4 col-md-3">審核時間</dt>
            <dd class="col-8 col-md-9">{{ $dataUpdateRequest->review_at }}</dd>
        </dl>
    </div>
</div>
<div class="row text-break">
    <div class="col">
        <b>原內容</b>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">原圖片</span></div>
            <blockquote>
                @if($dataUpdateRequest->originalImgurImage)
                    <img src="{{ $dataUpdateRequest->originalImgurImage->thumbnail('t') }}" alt="Club image">
                    <a href="{{ $dataUpdateRequest->originalImgurImage->url }}" target="_blank">
                        {{ $dataUpdateRequest->originalImgurImage->file_name }}
                    </a>
                @endif
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團簡介</span></div>
            <blockquote>
                {!! $dataUpdateRequest->original_description !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">額外資訊</span></div>
            <blockquote>
                {{--                {!! $contentPresenter->showContent($dataUpdateRequest->original_extra_info) !!}--}}
                {!! $dataUpdateRequest->original_extra_info !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團網址</span></div>
            @if($dataUpdateRequest->original_url)
                {{ link_to($dataUpdateRequest->original_url, $dataUpdateRequest->original_url, ['target' => '_blank']) }}
            @endif
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">自訂問題</span></div>
            <blockquote>
                {{ $dataUpdateRequest->original_custom_question }}
            </blockquote>
        </div>
    </div>
    <div class="col">
        <b>新內容</b>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">新圖片</span></div>
            <blockquote>
                @if($dataUpdateRequest->imgurImage)
                    <img src="{{ $dataUpdateRequest->imgurImage->thumbnail('t') }}" alt="Club image">
                    <a href="{{ $dataUpdateRequest->imgurImage->url }}" target="_blank">
                        {{ $dataUpdateRequest->imgurImage->file_name }}
                    </a>
                @else
                    <small class="text-muted">（不更換圖片）<br/>
                        （←請參考左側圖片）</small>
                @endif
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團簡介</span></div>
            <blockquote>
                {!! $dataUpdateRequest->description !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">額外資訊</span></div>
            <blockquote>
                {!! $dataUpdateRequest->extra_info !!}
            </blockquote>
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">社團網址</span></div>
            @if($dataUpdateRequest->url)
                {{ link_to($dataUpdateRequest->url, $dataUpdateRequest->url, ['target' => '_blank']) }}
            @endif
        </div>
        <div>
            <div style="font-weight: bold; font-size: 1.2rem"><span class="badge badge-secondary">自訂問題</span></div>
            <blockquote>
                {{ $dataUpdateRequest->custom_question }}
            </blockquote>
        </div>
    </div>
</div>
