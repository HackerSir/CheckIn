<footer class="footer" style="background-color: #292b2c;">
    <div class="container" style="padding: 15px 10px">
        <p class="text-muted" style="margin-bottom: 8px">
            ©2017-{{ \Carbon\Carbon::now()->year }}
            <a href="https://hackersir.org/" target="_blank" style="color: #636c72;">逢甲大學黑客社 HackerSir</a>.
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
            <li class="breadcrumb-item">
                <a href="https://www.instagram.com/fcu_hackersir/" target="_blank" style="color: #636c72;"><i
                        class="fab fa-instagram mr-1"></i>黑客社</a>
            </li>
            <li class="breadcrumb-item">
                <a href="https://www.instagram.com/fcu_afterclass/" target="_blank" style="color: #636c72;"><i
                        class="fab fa-instagram mr-1"></i>課外活動組</a>
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
