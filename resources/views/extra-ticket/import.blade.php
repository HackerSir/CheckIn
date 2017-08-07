@extends('layouts.app')

@section('title', '匯入額外抽獎編號')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>匯入額外抽獎編號</h1>
            <div class="card">
                <div class="card-block">
                    <ul>
                        <li>檔案須為xls或xlsx</li>
                        <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                        <li>欄位自左起依序為<code>學號(NID)</code>、<code>姓名</code>、<code>系級</code></li>
                        <li>上述三欄皆須填寫，若有留空則該筆資料<u>不會</u>匯入</li>
                        <li><code>學號(NID)</code>不得重複，重複則以最後一次出現為有效資料</li>
                        <li>匯入名單時，將根據<code>學號(NID)</code>覆寫現有資料</li>
                        <li>
                            範例檔案可{{ link_to_route('extra-ticket.download-import-sample', '按此下載') }}或參考下圖<br/>
                            <img src="data:image/png;base64,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" />
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-block">
                    {{ Form::open(['route' => 'extra-ticket.import', 'files' => true]) }}

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
                            <a href="{{ route('extra-ticket.index') }}" class="btn btn-secondary">返回列表</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
