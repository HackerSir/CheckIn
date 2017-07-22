@extends('layouts.app')

@section('title', '新增 QR Code 集')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>新增 QR Code 集</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('qrcode-set.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('amount') ? ' has-danger' : '' }}">
                            <label for="amount" class="col-md-2 col-form-label">數量</label>

                            <div class="col-md-10">
                                <input id="amount" type="number"
                                       class="form-control{{ $errors->has('nid') ? ' form-control-danger' : '' }}"
                                       name="amount" required autofocus min="1" value="1">

                                @if ($errors->has('amount'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary"> 新增 QR Code 集</button>
                                <a href="{{ route('qrcode-set.index') }}" class="btn btn-secondary">返回 QR Code 集</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
