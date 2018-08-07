@extends('layouts.base')

@section('title', '社團資料更新申請')

@section('buttons')
    <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
    <a href="{{ route('own-club.data-update-request.create') }}" class="btn btn-primary">
        <i class="fa fa-edit" aria-hidden="true"></i> 提交申請
    </a>
@endsection
@section('main_content')
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
