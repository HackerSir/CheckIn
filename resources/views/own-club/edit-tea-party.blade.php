@extends('layouts.base')

@section('title', $club->name . ' - 編輯迎新茶會')

@section('buttons')
    <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 返回
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('own-club.update-tea-party'), ['model' => $club->teaParty]) }}
            @include('tea-party.common-form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
