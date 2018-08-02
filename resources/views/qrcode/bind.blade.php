@extends('layouts.base')

@section('title', '綁定 QR Code')

@section('css')
    <style>
        input.upper {
            text-transform: uppercase;
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('qrcode.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code
    </a>
@endsection

@section('main_content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    {{ bs()->openForm('post', route('qrcode.bind')) }}
                    {{ bs()->formGroup(bs()->inputGroup(bs()->text('nid')->required()->autofocus())
                    ->suffix(bs()->button(fa()->times())->attributes(['onclick' => "$('input#nid').val('');$('input#nid').focus();return false;"]), false))->label('學號')->showAsRow() }}
                    {{ bs()->formGroup(bs()->inputGroup(bs()->text('code')->required()->autofocus())
                    ->suffix(bs()->button(fa()->times())->attributes(['onclick' => "$('input#code').val('');$('input#code').focus();return false;"]), false))->label('代號')->showAsRow() }}

                    <div class="row">
                        <div class="mx-auto">
                            {{ bs()->submit('綁定 QR Code', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                        </div>
                    </div>
                    {{ bs()->closeForm() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">綁定紀錄</div>
                <div class="card-body">
                    <ul>
                        @foreach($qrcodes as $qrcode)
                            <li>
                                <span class="badge badge-secondary code">{{ $qrcode->code }}</span>
                                {{ $qrcode->student->display_name }}
                                <br/>
                                <small class="text-muted">
                                    {{ $qrcode->bind_at }}
                                    （{{ $qrcode->bind_at->diffForHumans() }}）
                                </small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('form').on('submit', function () {
            //全部轉大寫
            $('input.upper[type=text]').val(function () {
                return this.value.toUpperCase();
            });
            var nidInput = $('input#nid');
            var codeInput = $('input#code');
            //原輸入值
            var nid = nidInput.val();
            var code = codeInput.val();
            //NID簡易正則表達式
            var re = /^[a-zA-Z]\d+$/;
            //若code比nid還像NID
            if (!re.test(nid) && re.test(code)) {
                //交換
                nidInput.val(code);
                codeInput.val(nid);
            }
        });
    </script>
@endsection
