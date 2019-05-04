@extends('layouts.app')

@section('title', '我的條碼')

@section('content')
    <div class="mt-3 pb-3">
        <div class="mt-1 mb-3">
            <div class="card">
                <div class="card-body">
                    <h1>QR Code</h1>
                    <div class="text-center">
                        @if($student->qrcode)
                            <p class="text-danger">聆聽攤位解說後，請出示此 QR Code 以進行打卡</p>
                            <img src="{{ route('code-picture.qrcode', $student->qrcode->code) }}" class="img-fluid">
                        @else
                            <div class="alert alert-danger" role="alert">
                                o_O 沒有 QR Code？<br/>
                                請嘗試重新登入，讓系統產生新的 QR Code
                            </div>
                        @endif
                        <p class="mt-1">集點時間：<span style="white-space: pre;">{{ $startAt }}</span> ~ <span
                                style="white-space: pre;">{{ $endAt }}</span></p>
                    </div>

                    <hr/>

                    <h1>抽獎活動</h1>
                    @include('components.mission-info', ['student' => $student])
                    <div class="text-center">
                        @if($student->studentSurvey)
                            <a href="{{ route('survey.student.show') }}" class="btn btn-success">
                                <i class="fa fa-search"></i> 檢視平台問卷
                            </a>
                        @elseif(Carbon\Carbon::now()->gt(new Carbon\Carbon(Setting::get('end_at'))))
                            <button type="button" class="btn btn-primary disabled">
                                <i class="fa fa-edit"></i> 填寫平台問卷
                            </button>
                            <small class="text-danger">已超過填寫時間</small>
                        @elseif(!$student->has_enough_counted_records)
                            <button type="button" class="btn btn-primary disabled">
                                <i class="fa fa-edit"></i> 填寫平台問卷
                            </button><br/>
                            <small class="text-danger">請先完成<strong>打卡集點</strong></small>
                        @else
                            <a href="{{ route('survey.student.edit') }}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> 填寫平台問卷
                            </a>
                        @endif
                    </div>

                    <hr/>

                    <h1>打卡集點</h1>
                    @include('components.check-in-progress', ['student' => $student])

                    <hr/>

                    <h1>打卡紀錄</h1>
                    @include('components.record-list', ['student' => $student, 'showFeedbackButton' => true])
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Modal --}}
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">訊息</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="alertMessage"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">確認</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">訊息</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="confirmMessage"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">稍後再說</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">前往填寫</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"
            integrity="sha256-CutOzxCRucUsn6C6TcEYsauvvYilEniTXldPa6/wu0k=" crossorigin="anonymous"></script>
    <script src="{{ asset(mix('/build-js/checkin.js')) }}"></script>
@endsection
