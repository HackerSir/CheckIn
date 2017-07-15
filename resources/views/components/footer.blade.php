<footer class="footer bg-inverse">
    <div class="container" style="padding: 15px 0">
        <p class="text-muted" style="margin-bottom: 8px">©2017 HackerSir. All rights reserved.</p>
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
