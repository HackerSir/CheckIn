@extends('layouts.base')

@section('title', '新增 QR Code 集')

@section('buttons')
    <a href="{{ route('qrcode-set.index') }}" class="btn btn-secondary mb-2">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> QR Code 集
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <form role="form" method="POST" action="{{ route('qrcode-set.store') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('amount') ? ' has-danger' : '' }}">
                    <label for="amount" class="col-md-2 col-form-label">QR碼數量</label>

                    <div class="col-md-10">
                        <input id="amount" type="number"
                               class="form-control{{ $errors->has('amount') ? ' form-control-danger' : '' }}"
                               name="amount" required autofocus min="1" value="1">

                        @if ($errors->has('amount'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check" aria-hidden="true"></i> 新增 QR Code 集
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
