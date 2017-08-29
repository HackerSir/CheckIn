@extends('layouts.app')

@section('title', '新增學生')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('student.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
            </a>
            <h1>新增學生</h1>
            <div class="card">
                <div class="card-block">
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
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check" aria-hidden="true"></i> 新增學生
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
