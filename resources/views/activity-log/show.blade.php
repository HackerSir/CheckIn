@extends('layouts.base')

@section('title', '檢視活動紀錄')

@section('buttons')
    <a href="{{ route('activity-log.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 活動紀錄
    </a>
@endsection

@section('css')
    @parent
    <style>
        pre.json {
            min-height: 1.2rem;
            margin: 0;
        }
    </style>
@endsection
@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>活動紀錄</h1>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">#</dt>
                <dd class="col-md-10">{{ $activity->id }}</dd>
                <dt class="col-md-2">Log Name</dt>
                <dd class="col-md-10">{{ $activity->log_name }}</dd>
                <dt class="col-md-2">Description</dt>
                <dd class="col-md-10">{{ $activity->description }}</dd>
            </dl>
            <hr>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">Subject</dt>
                <dd class="col-md-10">
                    <pre class="json border border-primary rounded">{{ $activity->subject }}</pre>
                </dd>
                <dt class="col-md-2">Subject Id</dt>
                <dd class="col-md-10">{{ $activity->subject_id }}</dd>
                <dt class="col-md-2">Subject Type</dt>
                <dd class="col-md-10">{{ $activity->subject_type }}</dd>
            </dl>
            <hr>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">Causer</dt>
                <dd class="col-md-10">
                    <pre class="json border border-primary rounded">{{ $activity->causer }}</pre>
                </dd>
                <dt class="col-md-2">Causer Id</dt>
                <dd class="col-md-10">{{ $activity->causer_id }}</dd>
                <dt class="col-md-2">Causer Type</dt>
                <dd class="col-md-10">{{ $activity->causer_type }}</dd>
            </dl>
            <hr>
            <dl class="row" style="font-size: 120%">
                <dt class="col-md-2">Properties</dt>
                <dd class="col-md-10">
                    <pre class="json border border-primary rounded">{{ $activity->properties }}</pre>
                </dd>
                <dt class="col-md-2">Created At</dt>
                <dd class="col-md-10">{{ $activity->created_at }}</dd>
            </dl>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        $(function () {
            $('pre.json').each(function () {
                let temp = $(this).text();
                if (temp !== '') {
                    $(this).text(JSON.stringify(JSON.parse($(this).text()), null, 2));
                }
            })
        });
    </script>
@endsection
