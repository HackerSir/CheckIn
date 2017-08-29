@extends('layouts.app')

@section('title', '匯入隊輔抽獎編號')

@section('content')
    <div class="mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('extra-ticket.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 隊輔抽獎編號管理
            </a>
            <h1>匯入隊輔抽獎編號</h1>
            <div class="card">
                <div class="card-block">
                    <ul>
                        <li>檔案須為xls或xlsx</li>
                        <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                        <li>欄位自左起依序為<code>抽獎編號</code>、<code>學號(NID)</code>、<code>姓名</code>、<code>系級</code></li>
                        <li>上述三欄皆須填寫，若有留空則該筆資料<u>不會</u>匯入</li>
                        <li><code>抽獎編號</code>必須為正整數，若留白或非正整數，將由系統自動分配</li>
                        <li><code>抽獎編號</code>與<code>學號(NID)</code>皆不得重複，重複則以最後一次出現為有效資料</li>
                        <li>匯入名單時，將根據<code>抽獎編號</code>與<code>學號(NID)</code>覆寫現有資料</li>
                        <li>
                            範例檔案可{{ link_to_route('extra-ticket.download-import-sample', '按此下載') }}或參考下圖<br/>
                            <img class="img-fluid"
                                 src="data:image/png;base64,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"/>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check" aria-hidden="true"></i> 確認
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
