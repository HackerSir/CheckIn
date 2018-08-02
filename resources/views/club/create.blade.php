@extends('layouts.base')

@section('title', '新增社團')

@section('buttons')
    <a href="{{ route('club.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('club.store'), ['files' => true]) }}
            @include('club.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
