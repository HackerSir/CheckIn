<footer class="footer bg-inverse">
    <div class="container" style="padding: 15px 0">
        <p class="text-muted" style="margin-bottom: 8px">©2017 HackerSir. All rights reserved.</p>
        <ol class="breadcrumb" style="padding: 0; margin-bottom: 0; background-color: #292b2c;">
            <li class="breadcrumb-item" style="color: #636c72">隱私權</li>
            <li class="breadcrumb-item" style="color: #636c72">服務條款</li>
            {{--<li>{!! HTML::linkRoute('privacy', '隱私權') !!}</li>--}}
            {{--<li>{!! HTML::linkRoute('terms', '服務條款') !!}</li>--}}
            {{--<li>{!! HTML::linkRoute('FAQ', '常見問題') !!}</li>--}}
            {{--<li>{!! HTML::linkRoute('staff', '工作人員') !!}</li>--}}
            {{--<li><a href="mailto:{{ urlencode('"駭客出任務"') }}<ics@mail.fcu.edu.tw>" target="_blank"><span class="glyphicon glyphicon-envelope" aria-hidden="true" style="margin-right: 5px;"></span>聯絡我們</a></li>--}}
            @if(Auth::guest())
                <li class="breadcrumb-item">
                    {!! link_to_route('login', '管理員登入', [], [
                        'style' => 'color: #636c72;',
                    ]) !!}
                </li>
            @endif
        </ol>
    </div>
</footer>
