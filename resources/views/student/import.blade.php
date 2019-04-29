@extends('layouts.base')

@section('title', '匯入學生')

@section('buttons')
    <a href="{{ route('student.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>檔案須為xls或xlsx</li>
                <li>第一列為標題列，<u>不會</u>作為資料匯入</li>
                <li>
                    欄位自左起依序為<code>NID</code>、<code>姓名</code>、<code>班級</code>、<code>類型</code>、<code>科系ID</code>、<code>科系</code>、<code>學院ID</code>、<code>學院</code>、<code>入學年度</code>、<code>性別</code>
                </li>
                <li>欄位名稱與順序須與範例相符</li>
                <li><code>NID</code>須填寫，若該欄留空，則該筆資料<u>不會</u>匯入</li>
                <li><code>NID</code>須符合NID格式</li>
                <li><code>NID</code>不得重複，重複將可能導致匯入失敗</li>
                <li><code>類型</code>為「教職員工」或「學生」，但目前任意填寫並不會造成影響</li>
                <li><code>入學年度</code>須為整數</li>
                <li><code>性別</code>為大寫「M」或「F」，但目前任意填寫並不會造成影響</li>
                <li>匯入時，將根據<code>NID</code>覆寫現有虛構資料（實際資料不受影響）</li>
                <li>
                    範例檔案可{{ link_to_route('student.download-import-sample', '按此下載') }}或參考下圖<br/>
                    <img class="img-fluid" alt="範例圖片"
                         src="data:image/png;base64,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"/>
                    <img class="img-fluid" alt="範例圖片"
                         src="data:image/png;base64,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"/>
                </li>
            </ul>
        </div>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('student.import'), ['files' => true]) }}
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
