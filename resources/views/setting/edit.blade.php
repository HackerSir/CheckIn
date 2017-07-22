@extends('layouts.app')

@section('title', '網站設定')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>網站設定</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('setting.update') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('start_at') ? ' has-danger' : '' }}">
                            <label for="start_at" class="col-md-3 col-form-label">開始打卡時間</label>

                            <div class="col-md-9">
                                <input id="start_at" name="start_at" type="text"
                                       class="form-control{{ $errors->has('start_at') ? ' form-control-danger' : '' }}"
                                       required value="{{ Setting::get('start_at') }}">

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
                                <input id="end_at" name="end_at" type="text"
                                       class="form-control{{ $errors->has('end_at') ? ' form-control-danger' : '' }}"
                                       required value="{{ Setting::get('end_at') }}">

                                @if ($errors->has('end_at'))
                                    <span class="form-control-feedback">
                                        <strong>{{ $errors->first('end_at') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary"> 更新設定</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            $('#start_at').datetimepicker();
            $('#end_at').datetimepicker();
        });
    </script>
@endsection
