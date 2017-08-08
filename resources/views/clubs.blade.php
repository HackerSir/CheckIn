@extends('layouts.app')

@section('title', '社團清單')

@section('content')
    <div class="mt-3 pb-3">
        <div class="card">
            <div class="card-block">
                <h1>社團攤位</h1>
                社團分類：
                <select id="type_select" class="custom-select">
                    <option @if(!$type)selected @endif>全部</option>
                    @foreach($clubTypes as $clubType)
                        <option type="button" class="btn btn-secondary" data-id="{{ $clubType->id }}"
                                @if($type == $clubType->id)selected @endif>
                            {{ $clubType->name }}
                        </option>
                    @endforeach
                </select>
                <div class="row mt-1">
                    @foreach($clubs as $club)
                        <div class="col-12 col-lg-6 mt-1">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-4" style="padding: 0">
                                            @if($club->imgurImage)
                                                <img src="{{ $club->imgurImage->thumbnail('b') }}" class="img-fluid">
                                            @else
                                                <img src="holder.js/160x160?random=yes&auto=yes" class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="col-8">
                                            <h3 class="card-title">{{ $club->name }}</h3>
                                            <p class="card-text">With supporting text below as a natural lead-in to
                                                additional content.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
    <script>
        $("#type_select").change(function () {
            var id = $("#type_select option:selected").data('id');
            console.log(id);
            if (id) {
                window.location.href = 'clubs?type=' + id;
            }
            else {
                window.location.href = 'clubs';
            }
        });
    </script>
@endsection
