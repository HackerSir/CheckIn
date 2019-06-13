@extends('layouts.base')

@section('title', '填寫回饋資料')

@section('buttons')
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection

@section('main_content')
    <div class="alert alert-info" role="alert">
        填寫社團回饋資料，方便社團日後聯絡你
    </div>
    <div class="alert alert-warning" role="alert">
        請注意：
        <ul style="padding-left: 20px">
            <li>對每個社團只能填寫一份回饋資料，送出後仍可於回饋資料填寫截止（{{ new Carbon\Carbon(Setting::get('feedback_create_expired_at')) }}
                ）之前多次修改，截止後將無法填寫或修改
            </li>
            <li>
                送出回饋資料後，該社團可以取得您以下的資訊：
                <ul>
                    <li>學號</li>
                    <li>姓名</li>
                    <li>班級</li>
                    <li>科系</li>
                    <li>學院</li>
                    <li>入學年度</li>
                    <li>性別</li>
                </ul>
                以及您下方勾選的資料
                <ul>
                    <li>電話</li>
                    <li>信箱</li>
                    <li>Facebook 個人檔案連結</li>
                    <li>LINE ID</li>
                    <li>給社團的意見</li>
                </ul>
            </li>
            <li>請至少勾選一項<strong>聯絡資訊</strong>資料再送出</li>
        </ul>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('feedback.store', $club), ['model' => $feedback]) }}

            <div class="form-group row">
                <label class="col-md-2 col-form-label">基本資料</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {{ $user->student->display_name }}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">社團</label>
                <div class="col-md-10">
                    <p class="form-control-plaintext">
                        {!! $club->display_name ?? '' !!}
                    </p>
                </div>
            </div>

            @if($user->student->contactInformation->phone)
                {{ bs()->formGroup(bs()->checkBox('include_phone', $user->student->contactInformation->phone))->label('電話')->showAsRow() }}
            @else
                {{ bs()->formGroup(bs()->checkBox('include_phone', '未填寫')->disabled())->label('電話')->showAsRow() }}
            @endif

            @if($user->student->contactInformation->email)
                {{ bs()->formGroup(bs()->checkBox('include_email', $user->student->contactInformation->email))->label('信箱')->showAsRow() }}
            @else
                {{ bs()->formGroup(bs()->checkBox('include_email', '未填寫')->disabled())->label('信箱')->showAsRow() }}
            @endif

            @if($user->student->contactInformation->facebook)
                {{ bs()->formGroup(bs()->checkBox('include_facebook', $user->student->contactInformation->facebook))->label('Facebook')->showAsRow() }}
            @else
                {{ bs()->formGroup(bs()->checkBox('include_facebook', '未填寫')->disabled())->label('Facebook')->showAsRow() }}
            @endif

            @if($user->student->contactInformation->line)
                {{ bs()->formGroup(bs()->checkBox('include_line', $user->student->contactInformation->line))->label('LINE ID')->showAsRow() }}
            @else
                {{ bs()->formGroup(bs()->checkBox('include_line', '未填寫')->disabled())->label('LINE ID')->showAsRow() }}
            @endif

            {{ bs()->formGroup(bs()->text('message'))->label('給社團的意見')->showAsRow() }}

            @if($club->custom_question)
                <hr/>
                @if(isset($feedback) && $feedback->custom_question != $club->custom_question)
                    <div class="alert alert-danger">社團提問內容稍早已被變更，可能需要重新回答問題</div>
                @endif
                {{ bs()->formGroup(html()->div($club->custom_question)->class('form-control-plaintext'))->label('社團提問')->showAsRow() }}
                {{ bs()->formGroup(bs()->text('answer_of_custom_question'))->label('你的回答')->showAsRow() }}
            @endif

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('送出', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
