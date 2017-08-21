@extends('layouts.app')

@section('title', '匯入攤位')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>匯入攤位</h1>
            <div class="card">
                <div class="card-block">
                    <ul>
                        <li>檔案須為xls或xlsx</li>
                        <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                        <li>欄位自左起依序為<code>攤位編號</code>、<code>緯度</code>、<code>經度</code></li>
                        <li>上述三欄皆須填寫，若有留空或格式有誤，則該筆資料<u>不會</u>匯入</li>
                        <li><code>攤位編號</code>不得重複，重複則以最後一次出現為有效資料</li>
                        <li>匯入名單時，將根據<code>攤位編號</code>覆寫現有資料</li>
                        <li>
                            範例檔案可{{ link_to_route('booth.download-import-sample', '按此下載') }}或參考下圖<br/>
                            <img class="img-fluid" src="data:image/png;base64,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" />
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-block">
                    {{ Form::open(['route' => 'booth.import', 'files' => true]) }}

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
                            <a href="{{ route('booth.index') }}" class="btn btn-secondary">返回列表</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
