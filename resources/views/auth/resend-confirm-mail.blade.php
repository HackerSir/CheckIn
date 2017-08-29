@extends('layouts.app')

@section('title', '重新發送驗證信件')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <h1>重新發送驗證信件</h1>
            <div class="card">
                <div class="card-block">
                    <form role="form" method="POST" action="{{ route('confirm-mail.resend') }}">
                        {{ csrf_field() }}

                        <div class="form-group row{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email" class="col-md-2 col-form-label">信箱</label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly>
                                <span class="form-text">信箱作為帳號使用，故無法修改</span>
                            </div>
                        </div>
                        <div class="alert alert-warning col-md-10 offset-md-2" role="alert">
                            請注意：
                            <ul>
                                <li>若信箱錯誤，請重新註冊帳號</li>
                                <li>發送前，請先確認信箱是否屬於自己</li>
                                <li>發送信件可能耗費幾分鐘，請耐心等待</li>
                                <li>僅最後一次發送之信件有效</li>
                            </ul>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i> 發送驗證信件
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
