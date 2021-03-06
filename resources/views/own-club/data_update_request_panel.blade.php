@extends('layouts.base')

@section('title', '社團資料修改申請')

@section('buttons')
    <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>返回
    </a>
    <a href="{{ route('own-club.data-update-request.create') }}" class="btn btn-primary">
        <i class="fa fa-edit mr-2"></i>提交申請
    </a>
@endsection

@section('container_class', 'container-fluid')
@section('main_content')
    <div class="alert alert-danger">
        {{-- 由於已超過資料編輯期限，--}}如欲修改社團資料，請透過此介面提交資料修改申請，受理期限請參閱課外活動組公告訊息
    </div>
    <div class="card">
        <div class="card-body">
            @foreach($club->dataUpdateRequests as $dataUpdateRequest)
                @include('club.data-update-request.info', compact('dataUpdateRequest'))
                @if($loop->remaining)
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
@endsection
