@extends('layouts.club.show')

@section('club-controls')
    <a href="{{ route('own-club.edit') }}" class="btn btn-primary">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> 編輯資料
    </a>
@endsection
