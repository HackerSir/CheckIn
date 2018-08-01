@extends('layouts.base')

@section('title', '新增學生')

@section('buttons')
    <a href="{{ route('student.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
    </a>
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <form role="form" method="POST" action="{{ route('student.store') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('nid') ? ' has-danger' : '' }}">
                    <label for="nid" class="col-md-2 col-form-label">學號</label>

                    <div class="col-md-10">
                        <input id="nid" type="text"
                               class="form-control{{ $errors->has('nid') ? ' form-control-danger' : '' }}"
                               name="nid" required autofocus>

                        @if ($errors->has('nid'))
                            <span class="form-control-feedback">
                                <strong>{{ $errors->first('nid') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check" aria-hidden="true"></i> 新增學生
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
