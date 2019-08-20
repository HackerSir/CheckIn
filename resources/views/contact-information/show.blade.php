@extends('layouts.base')

@section('title', $contactInformation->student->name . ' - 聯絡資料')

@section('buttons')
    <a href="{{ route('contact-information.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left mr-2"></i>聯絡資料
    </a>
    <a href="{{ route('contact-information.edit', $contactInformation) }}" class="btn btn-primary">
        <i class="fa fa-edit mr-2"></i>編輯
    </a>
    {!! Form::open(['route' => ['contact-information.destroy', $contactInformation], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
    <button type="submit" class="btn btn-danger">
        <i class="fa fa-trash mr-2"></i>刪除
    </button>
    {!! Form::close() !!}
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>聯絡資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">電話</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->phone)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->phone }}
                    @endif
                </dd>

                <dt class="col-md-2">信箱</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->email)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->email }}
                    @endif
                </dd>

                <dt class="col-md-2">Facebook</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->facebook)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->facebook }}
                    @endif
                </dd>

                <dt class="col-md-2">LINE ID</dt>
                <dd class="col-md-10">
                    @if(!$contactInformation->line)
                        <span class="text-muted">（未填寫）</span>
                    @else
                        {{ $contactInformation->line }}
                    @endif
                </dd>
            </dl>

            <hr>

            <h1>基本資料</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">學號(NID)</dt>
                <dd class="col-md-10">{{ $contactInformation->student->nid }}</dd>

                <dt class="col-md-2">姓名</dt>
                <dd class="col-md-10">
                    @if(Laratrust::can('student.manage'))
                        <a href="{{ route('student.show', $contactInformation->student) }}">
                            {!! $contactInformation->student->name !!}
                        </a>
                    @else
                        {{ $contactInformation->student->name }}
                    @endif
                </dd>

                <dt class="col-md-2">班級</dt>
                <dd class="col-md-10">{{ $contactInformation->student->class }}</dd>

                <dt class="col-md-2">科系</dt>
                <dd class="col-md-10">{{ $contactInformation->student->unit_name }}</dd>

                <dt class="col-md-2">學院</dt>
                <dd class="col-md-10">{{ $contactInformation->student->dept_name }}</dd>

                <dt class="col-md-2">入學年度</dt>
                <dd class="col-md-10">{{ $contactInformation->student->in_year }}</dd>

                <dt class="col-md-2">性別</dt>
                <dd class="col-md-10">{{ $contactInformation->student->gender }}</dd>

                <dt class="col-md-2">新生</dt>
                <dd class="col-md-10">
                    @if($contactInformation->student->is_freshman)
                        <i class="fa fa-check fa-2x text-success"></i>
                    @else
                        <i class="fa fa-times fa-2x text-danger"></i>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
@endsection
