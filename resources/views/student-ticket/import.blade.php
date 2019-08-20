@extends('layouts.base')

@section('title', '匯入學生抽獎編號')

@section('buttons')
    <a href="{{ route('student-ticket.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>學生抽獎編號管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>檔案須為xls或xlsx</li>
                <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                <li>欄位自左起依序為<code>抽獎編號</code>、<code>學號(NID)</code></li>
                <li><code>學號(NID)</code>須填寫，若有留空則該筆資料<u>不會</u>匯入</li>
                <li><code>學號(NID)</code>必須為本學期在校學生</li>
                <li><code>抽獎編號</code>必須為正整數，若留白或非正整數，將由系統自動分配</li>
                <li><code>抽獎編號</code>與<code>學號(NID)</code>皆不得重複，重複則以最後一次出現為有效資料</li>
                <li>匯入名單時，將根據<code>抽獎編號</code>與<code>學號(NID)</code>覆寫現有資料</li>
                <li>
                    範例檔案可{{ link_to_route('student-ticket.download-import-sample', '按此下載') }}或參考下圖<br/>
                    <img class="img-fluid"
                         src="data:image/png;base64,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"/>
                </li>
            </ul>
        </div>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('student-ticket.import'), ['files' => true]) }}
            {{ bs()->formGroup(bs()->simpleFile('import_file')->required()->accept('.xls,.xlsx'))->class('required')->label('檔案')->showAsRow() }}
            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
