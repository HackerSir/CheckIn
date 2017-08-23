@extends('layouts.club.show')

@section('club-controls')
    <a href="{{ route('own-club.edit') }}" class="btn btn-primary">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 編輯資料
    </a>
@endsection

@section('club-basic-info')
    <dt class="col-sm-3">負責人</dt>
    <dd class="col-sm-9">
        @foreach($club->users as $user)
            {{ $user->name }}<br/>
        @endforeach
    </dd>
@endsection
