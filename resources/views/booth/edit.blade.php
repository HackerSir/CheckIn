@extends('layouts.base')

@section('title', '編輯攤位')

@section('buttons')
    <a href="{{ route('booth.show', $booth) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>返回
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('booth.update', $booth), ['model' => $booth]) }}
            @include('booth.form')

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('select[name=club_id]').select2();
        });
    </script>
@endsection
