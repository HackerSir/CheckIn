@extends('layouts.app')

@section('title', $club->name . ' - 社團')

@section('css')
    <style>
        table tr td:first-child {
            white-space: nowrap
        }
    </style>
@endsection

@section('content')
    <div class="row mt-3 pb-3">
        <div class="col-md-8 offset-md-2">
            <h1>{{ $club->name }} - 社團</h1>
            <div class="card">
                @if($club->image_url)
                    <div class="card-block text-center">
                        <img src="{{ $club->image_url }}">
                    </div>
                @endif
                <div class="card-block">
                    <table class="table table-hover">
                        <tr>
                            <td class="text-md-right">類型：</td>
                            <td>{{ $club->clubType->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">名稱：</td>
                            <td>{{ $club->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">集點：</td>
                            <td>
                                @if($club->is_counted)
                                    <i class="fa fa-check fa-2x text-success" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-times fa-2x text-danger" aria-hidden="true"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">編號：</td>
                            <td>{{ $club->number }}</td>
                        </tr>
                        <tr>
                            <td class="text-md-right">攤位：</td>
                            <td>
                                @foreach($club->booths as $booth)
                                    {{ $booth->name }}<br/>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">網址：</td>
                            <td>
                                @if($club->url)
                                    {{ link_to($club->url, $club->url, ['target' => '_blank']) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-md-right">負責人：</td>
                            <td>
                                @foreach($club->users as $user)
                                    {{ $user->name }}<br/>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
                @if($club->description)
                    <div class="card-block">
                        {!! nl2br(e($club->description)) !!}
                    </div>
                @endif
                <div class="card-block text-center">
                    <a href="{{ route('own-club.edit') }}" class="btn btn-primary">編輯資料</a>
                </div>
            </div>
        </div>
    </div>
@endsection
