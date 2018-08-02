@extends('layouts.base')

@section('title', '新增社團類型')

@section('buttons')
    <a href="{{ route('club-type.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 社團類型管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('post', route('club-type.store')) }}
            @include('club-type.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
