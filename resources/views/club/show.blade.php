@extends('layouts.club.show')

@section('club-controls')
    <a href="{{ route('club.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團管理
    </a>
    <a href="{{ route('club.edit', $club) }}" class="btn btn-primary">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 編輯資料
    </a>
    {!! Form::open(['route' => ['club.destroy', $club], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash" aria-hidden="true"></i> 刪除社團
    </button>
    {!! Form::close() !!}
@endsection

@section('club-basic-info')
    <dt class="col-4 col-sm-3">負責人</dt>
    <dd class="col-8 col-sm-9">
        @foreach($club->users as $user)
            {{ $user->name }}<br/>
        @endforeach
    </dd>
@endsection
