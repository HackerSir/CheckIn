@extends('layouts.base')

@section('title', '聯絡資料')

@section('buttons')
    @if(\Carbon\Carbon::now()->lte(new Carbon\Carbon(Setting::get('feedback_create_expired_at'))))
        <a href="{{ route('contact-information.my.create-or-edit') }}" class="btn btn-primary">
            <i class="fa fa-edit mr-2"></i>編輯
        </a>
    @endif
@endsection

@section('main_content')
    @include('contact-information.my.alert')
    <div class="card">
        <div class="card-body">
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">電話</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->phone)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->phone }}
                    @endif
                </dd>

                <dt class="col-md-2">信箱</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->email)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->email }}
                    @endif
                </dd>

                <dt class="col-md-2">Facebook</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->facebook)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->facebook }}
                    @endif
                </dd>

                <dt class="col-md-2">LINE ID</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->line)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->line }}
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
