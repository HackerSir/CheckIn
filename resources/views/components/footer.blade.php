<footer class="footer" style="background-color: #292b2c;">
    <div class="container" style="padding: 15px 10px">
        <p class="text-muted" style="margin-bottom: 8px">
            ©2017-{{ \Carbon\Carbon::now()->year }}
            <a href="https://www.facebook.com/HackerSir.tw" target="_blank" style="color: #636c72;">逢甲大學黑客社 HackerSir</a>.
            All rights reserved.
        </p>
        <ol class="breadcrumb" style="padding: 0; margin-bottom: 0; background-color: #292b2c;">
            <li class="breadcrumb-item" style="color: #636c72">
                {!! link_to_route('faq', '常見問題', [], [
                        'style' => 'color: #636c72;',
                    ]) !!}
            </li>
            <li class="breadcrumb-item" style="color: #636c72">
                {!! link_to_route('terms', '服務條款', [], [
                        'style' => 'color: #636c72;',
                    ]) !!}
            </li>
            <li class="breadcrumb-item" style="color: #636c72">
                {!! link_to_route('development-team', '開發團隊', [], [
                        'style' => 'color: #636c72;',
                    ]) !!}
            </li>
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
