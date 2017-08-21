@extends('layouts.app')

@section('title', '匯入社團')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>匯入社團</h1>
            <div class="card">
                <div class="card-block">
                    <ul>
                        <li>檔案須為xls或xlsx</li>
                        <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                        <li>欄位自左起依序為<code>社團名稱</code>、<code>社團編號</code>、<code>社團類型</code>
                            、<code>攤位負責人1</code>、<code>攤位負責人2</code>、……、<code>攤位負責人5</code></li>
                        <li><code>社團名稱</code>須填寫，若該欄留空，則該筆資料<u>不會</u>匯入</li>
                        <li><code>社團名稱</code>不得重複，重複則以最後一次出現為有效資料</li>
                        <li>匯入名單時，將根據<code>社團名稱</code>覆寫現有資料</li>
                        <li>每個社團最多僅能填寫五位<code>攤位負責人</code>，若需填寫更多，請於匯入後利用網站介面編輯</li>
                        <li>每個NID僅能擔任一次<code>攤位負責人</code>，若NID有重複或無效，則匯入結果無法保證，強烈建議匯入後逐一檢查設定</li>
                        <li>
                            範例檔案可{{ link_to_route('club.download-import-sample', '按此下載') }}或參考下圖<br/>
                            <img class="img-fluid" src="data:image/png;base64,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" />
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-block">
                    {{ Form::open(['route' => 'club.import', 'files' => true]) }}

                    <div class="form-group row{{ $errors->has('import_file') ? ' has-danger' : '' }}">
                        <label for="import_file" class="col-md-2 col-form-label">檔案</label>
                        <div class="col-md-10">
                            {{ Form::file('import_file', ['class' => 'form-control', 'required', 'accept' => '.xls,.xlsx']) }}
                            @if ($errors->has('import_file'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('import_file') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-primary"> 確認</button>
                            <a href="{{ route('club.index') }}" class="btn btn-secondary">返回列表</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection