@extends('layouts.app')

@section('title', $booth->name . ' - 攤位')

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <a href="{{ route('booth.index') }}" class="btn btn-secondary mb-2">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> 攤位管理
            </a>
            <h1>{{ $booth->name }} - 攤位</h1>
            <div class="card">
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">攤位編號：</td>
                            <td>{{ $booth->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">社團：</td>
                            <td>
                                @if($booth->club)
                                    {{ link_to_route('club.show', $booth->club->name, $booth->club) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">經緯度：</td>
                            <td>{{ $booth->longitude }} / {{ $booth->latitude }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-block text-center">
                    <a href="{{ route('booth.edit', $booth) }}" class="btn btn-primary">編輯資料</a>
                    {!! Form::open(['route' => ['booth.destroy', $booth], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
                    <button type="submit" class="btn btn-danger">刪除攤位</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
