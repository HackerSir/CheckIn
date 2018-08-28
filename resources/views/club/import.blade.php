@extends('layouts.base')

@section('title', '匯入社團')

@section('buttons')
    <a href="{{ route('club.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>檔案須為xls或xlsx</li>
                <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                <li>欄位自左起依序為<code>社團名稱</code>、<code>社團編號</code>、<code>社團類型</code>、<code>攤位編號</code>
                    、<code>攤位負責人1</code>、<code>攤位負責人2</code>、……、<code>攤位負責人5</code></li>
                <li><code>社團名稱</code>須填寫，若該欄留空，則該筆資料<u>不會</u>匯入</li>
                <li><code>社團名稱</code>不得重複，重複則以最後一次出現為有效資料</li>
                <li><code>攤位編號</code>僅由已存在的攤位搜尋與綁定，若無該編號攤位存在，則忽略。已綁定之攤位不會因匯入而自動解除</li>
                <li>匯入名單時，將根據<code>社團名稱</code>覆寫現有資料</li>
                <li>每個社團最多僅能填寫五位<code>攤位負責人</code>，若需填寫更多，請於匯入後利用網站介面編輯</li>
                <li>每個NID僅能擔任一次<code>攤位負責人</code>，若NID有重複或無效，則匯入結果無法保證，強烈建議匯入後逐一檢查設定</li>
                <li>
                    範例檔案可{{ link_to_route('club.download-import-sample', '按此下載') }}或參考下圖<br/>
                    <img class="img-fluid"
                         src="data:image/png;base64,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"/>
                </li>
            </ul>
        </div>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('club.import'), ['files' => true]) }}
            {{ bs()->formGroup(bs()->simpleFile('import_file')->required()->accept('.xls,.xlsx'))->label('檔案')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
