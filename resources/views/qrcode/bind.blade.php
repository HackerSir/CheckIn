@extends('layouts.app')

@section('title', '綁定 QR Code')

@section('css')
    <style>
        input.upper {
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-8">
            <h1>綁定 QR Code</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('qrcode.bind') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('nid') ? ' has-danger' : '' }}">
                            <label for="nid" class="col-md-2 col-form-label">學號</label>

                            <div class="col-md-10">
                                <div class="input-group">
                                    <input id="nid" type="text" value="{{ old('nid') }}"
                                           class="upper form-control{{ $errors->has('nid') ? ' form-control-danger' : '' }}"
                                           name="nid" required autofocus>
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" type="button"
                                                onclick="$('input#nid').val('');$('input#nid').focus()">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </span>
                                </div>
                                @if ($errors->has('nid'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('nid') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('code') ? ' has-danger' : '' }}">
                            <label for="code" class="col-md-2 col-form-label">代號</label>

                            <div class="col-md-10">
                                <div class="input-group">
                                    <input id="code" type="text" value="{{ old('code') }}"
                                           class="upper form-control{{ $errors->has('code') ? ' form-control-danger' : '' }}"
                                           name="code" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" type="button"
                                                onclick="$('input#code').val('');$('input#code').focus()">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </span>
                                </div>

                                @if ($errors->has('code'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary"> 綁定 QR Code</button>
                                <a href="{{ route('qrcode.index') }}" class="btn btn-secondary">返回 QR Code 管理</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h1>綁定紀錄</h1>
            <div class="card">
                <div class="card-block">
                    <ul>
                        @foreach($qrcodes as $qrcode)
                            <li>
                                <span class="badge badge-default">{{ $qrcode->code }}</span>
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
