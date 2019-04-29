@extends('layouts.base')

@section('title', $student->name . ' - 編輯學生')

@section('buttons')
    <a href="{{ route('student.show', $student) }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 檢視學生
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            {{ bs()->openForm('patch', route('student.update', $student), ['model' => $student]) }}
            @if($student->is_dummy)
                @include('student.form')
            @else
                @include('student.readonly-form')
            @endif

            <div class="row">
                <div class="mx-auto">
                    {{ bs()->submit('確認', 'primary')->prependChildren(fa()->icon('check')->addClass('mr-2')) }}
                </div>
            </div>
            {{ bs()->closeForm() }}
        </div>
    </div>
@endsection
