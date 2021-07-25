@extends('layouts.base')

@section('title', '填寫回饋資料')

@section('buttons')
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>返回
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
                以及您下方勾選或填寫的資料
                <ul>
                    <li>電話</li>
                    <li>信箱</li>
                    <li>Facebook 個人檔案連結</li>
                    <li>LINE ID</li>
                    <li>給社團的意見</li>
                    <li>對於社團提問的回答</li>
                    <li>加入社團意願</li>
                    <li>參與迎新茶會意願</li>
                </ul>
            </li>
            <li>請至少勾選一項<strong>聯絡資訊</strong>資料再送出</li>
            <li>若對於加入社團與參加茶會皆無意願，則該社團無法取得此回饋資料</li>
        </ul>
    </div>
    <div class="card mt-1">
        <div class="card-body">
            {{ bs()->openForm('post', route('feedback.store', $club), ['model' => $feedback]) }}

            {{ bs()->formGroup(html()->div($user->student->display_name)->class('form-control-plaintext'))->label('基本資料')->showAsRow() }}
            {{ bs()->formGroup(html()->div($club->display_name ?? null)->class('form-control-plaintext'))->label('社團')->showAsRow() }}

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

            <hr/>
            {{--            {{ bs()->formGroup(bs()->select('join_club_intention', $intentionOptions)->required())->class('required')->label('加入社團意願')->showAsRow() }}--}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">加入社團意願</label>
                <div class="col-md-10">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach(\App\Models\Feedback::$intentionText as $key => $value)
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="join_club_intention" value="{{ $key }}" required
                                       @if(isset($feedback) && $feedback->join_club_intention == $key
                                       || !isset($feedback) && request()->has('join_club_intention') && request('join_club_intention') == $key) checked @endif> {{ $value }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">迎新茶會資訊</label>
                <div class="col-md-10">
                    <div class="form-control-plaintext">
                        @if($club->teaParty)
                            <dl class="row ">
                                <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-clock mr-2"></i>茶會名稱</dt>
                                <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->name }}</dd>

                                <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-clock mr-2"></i>開始時間</dt>
                                <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->start_at }}</dd>

                                <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-clock mr-2"></i>結束時間</dt>
                                <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->end_at }}</dd>

                                <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-map-marked-alt mr-2"></i>地點</dt>
                                <dd class="col-12 col-sm-8 col-lg-10">{{ $club->teaParty->location }}</dd>

                                @if($club->teaParty->url)
                                    <dt class="col-12 col-sm-4 col-lg-2"><i class="fas fa-link mr-2"></i>網址</dt>
                                    <dd class="col-12 col-sm-8 col-lg-10">
                                        <a href="{{ $club->teaParty->url }}"
                                           target="_blank">{{ $club->teaParty->url }}</a>
                                    </dd>
                                @endif
                            </dl>
                        @else
                            暫未提供相關資訊，請回答「若舉辦迎新茶會，是否有意願參與？」
                        @endif
                    </div>
                </div>
            </div>
            {{--            {{ bs()->formGroup(bs()->select('join_tea_party_intention', $intentionOptions)->required())->class('required')->label('參與迎新茶會意願')->showAsRow() }}--}}
            <div class="form-group row">
                <label class="col-md-2 col-form-label">參與迎新茶會意願</label>
                <div class="col-md-10">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        @foreach(\App\Models\Feedback::$intentionText as $key => $value)
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="join_tea_party_intention" value="{{ $key }}" required
                                       @if(isset($feedback) && $feedback->join_tea_party_intention == $key
                                       || !isset($feedback) && request()->has('join_tea_party_intention') && request('join_tea_party_intention') == $key) checked @endif> {{ $value }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('送出', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('.btn-group-toggle > label.btn:has(input[type=radio]:checked)').addClass('active')
        })
    </script>
@endsection
