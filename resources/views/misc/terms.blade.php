@extends('layouts.base')

@section('title', '服務條款 Terms of Service')

@section('main_content')
    <p class="text-right">修訂日期：2017年08月16日</p>
    <div class="card">
        <div class="card-body">
            @include('misc.terms-content')
        </div>
    </div>
@endsection
