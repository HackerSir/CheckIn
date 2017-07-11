@extends('layouts.app')

@section('title', 'Google 2FA')

@section('content')
    <div class="card">
        <div class="card-header">
            Google 2FA
        </div>
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('login.2fa') }}">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="one_time_password" class="col-md-4 col-form-label">OTP</label>

                    <div class="col-md-6">
                        <input id="one_time_password" name="one_time_password" type="text" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">Authenticate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
