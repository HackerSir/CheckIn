@extends('layouts.base')

@section('title', '新增迎新茶會')

@section('buttons')
    <a href="{{ route('tea-party.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 迎新茶會管理
    </a>
    @if(request('club_id'))
        <a href="{{ route('clubs.show', request('club_id')) }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> 檢視社團
        </a>
    @endif
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('tea-party.store')) }}
            @include('tea-party.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('新增迎新茶會', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
