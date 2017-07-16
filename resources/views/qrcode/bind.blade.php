@extends('layouts.app')

@section('title', '綁定 QR Code')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>綁定 QR Code</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('qrcode.bind') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('nid') ? ' has-danger' : '' }}">
                            <label for="nid" class="col-md-2 col-form-label">學號</label>

                            <div class="col-md-10">
                                <input id="nid" type="text"
                                       class="form-control{{ $errors->has('nid') ? ' form-control-danger' : '' }}"
                                       name="nid" required autofocus>

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
                                <input id="code" type="text"
                                       class="form-control{{ $errors->has('code') ? ' form-control-danger' : '' }}"
                                       name="code" required autofocus>

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
    </div>
@endsection
