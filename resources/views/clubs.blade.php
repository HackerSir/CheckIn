@extends('layouts.app')

@section('title', '社團清單')

@section('content')
    <div class="mt-3 pb-3">
        <div class="card">
            <div class="card-block">
                <h1>社團攤位</h1>
                類型
                <select id="type_select" class="custom-select">
                    <option @if(!$type)selected @endif>全部</option>
                    @foreach($clubTypes as $clubType)
                        <option type="button" class="btn btn-secondary" data-id="{{ $clubType->id }}"
                                @if($type == $clubType->id)selected @endif>
                            {{ $clubType->name }}
                        </option>
                    @endforeach
                </select>
                <div class="float-sm-right mt-1">
                    搜尋
                    <input type="text">
                </div>
                <club-cards></club-cards>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
    <script src="{{ mix('/build-js/vue.js') }}"></script>
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
