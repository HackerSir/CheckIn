@extends('layouts.app')

@section('title', '活動設定')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>活動設定</h1>
            <div class="card">
                <div class="card-block">
                    {{ Form::open(['route' => 'setting.update']) }}
                    <div class="form-group row{{ $errors->has('start_at') ? ' has-danger' : '' }}">
                        <label for="start_at" class="col-md-3 col-form-label">開始打卡時間</label>

                        <div class="col-md-9">
                            {{ Form::text('start_at', Setting::get('start_at'), ['class' => 'form-control', 'required']) }}

                            @if ($errors->has('start_at'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('start_at') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('end_at') ? ' has-danger' : '' }}">
                        <label for="end_at" class="col-md-3 col-form-label">結束打卡時間</label>

                        <div class="col-md-9">
                            {{ Form::text('end_at', Setting::get('end_at'), ['class' => 'form-control', 'required']) }}

                            @if ($errors->has('end_at'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('end_at') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row{{ $errors->has('target') ? ' has-danger' : '' }}">
                        <label for="target" class="col-md-3 col-form-label">打卡目標數量</label>

                        <div class="col-md-9">
                            {{ Form::number('target', Setting::get('target'), ['class' => 'form-control', 'required', 'min' => 0]) }}

                            @if ($errors->has('target'))
                                <span class="form-control-feedback">
                                    <strong>{{ $errors->first('target') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check" aria-hidden="true"></i> 更新設定
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('input[name=start_at]').datetimepicker();
            $('input[name=end_at]').datetimepicker();
        });
    </script>
@endsection
