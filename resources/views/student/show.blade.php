@extends('layouts.base')

@section('title', $student->name . ' - 學生')

@section('css')
    <style>
        #map {
            width: 100%;
            height: 70vh;
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('student.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> 學生管理
    </a>
    @can('update', $student)
        <a href="{{ route('student.edit', $student) }}" class="btn btn-primary">
            <i class="fa fa-edit" aria-hidden="true"></i> 編輯
        </a>
    @endcan
    @can('delete', $student)
        {!! Form::open(['route' => ['student.destroy', $student], 'style' => 'display: inline', 'method' => 'DELETE', 'onSubmit' => "return confirm('確定要刪除嗎？');"]) !!}
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-trash" aria-hidden="true"></i> 刪除
        </button>
        {!! Form::close() !!}
    @endcan
@endsection

@section('main_content')
    <div class="card">
        <div class="card-body">
            <h1>基本資料</h1>
            <dl class="row" style="font-size: 120%">
                @if($student->user && Laratrust::can('user.manage'))
                    <dt class="col-md-2">使用者</dt>
                    <dd class="col-md-10">
                        {{ link_to_route('user.show', $student->user->name, $student->user) }}
                    </dd>
                @endif
            </dl>

            @if($student->is_dummy)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>此筆資料為人為輸入之虛構資料，待該使用者登入後，將自動替換為學校提供之實際資料
                </div>
            @endif
            @include('student.info', compact('student'))

            <hr/>

            <h1>抽獎活動</h1>
            @include('components.mission-info', ['student' => $student])

            <hr/>

            <h1>打卡集點</h1>
            @include('components.check-in-progress', ['student' => $student])

            <hr/>

            <h1>QR Code</h1>

            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>代碼</th>
                    <th>綁定時間</th>
                </tr>
                </thead>
                <tbody>
                @forelse($student->qrcodes as $qrcode)
                    <tr>
                        <td>
                            @if(Laratrust::can('qrcode.manage'))
                                {{ link_to_route('qrcode.show', $qrcode->code, $qrcode, ['class' => 'code']) }}
                            @else
                                <span class="code">{{ $qrcode->code }}</span>
                            @endif
                            @if($qrcode->is_last_one)
                                <i class="fa fa-check text-success" aria-hidden="true" title="最後一組"></i>
                            @endif
                        </td>
                        <td>
                            {{ $qrcode->bind_at }}
                            （{{ $qrcode->bind_at->diffForHumans() }}）
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            暫無
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if(\Laratrust::can('student-path.view'))
                <hr/>

                <h1>移動路徑</h1>
                @if(request()->exists('path'))
                    <div class="mt-2" id="map"></div>
                @else
                    <a href="?path" class="btn btn-secondary">顯示移動路徑</a>
                @endif
            @endif

            <hr/>

            <h1>打卡紀錄</h1>
            @include('components.record-list', ['student' => $student])
        </div>
    </div>
@endsection

@section('js')
    @if(\Laratrust::can('student-path.view') && request()->exists('path'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ GoogleApi::getKey() }}"></script>
        <script src="{{ asset('js/maplabel-compiled.js') }}"></script>
        <script>
            var boothData = {!! json_encode($boothData) !!};
            var coordinates = {!! json_encode($path) !!};
        </script>
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 18,
                    center: {lat: 24.179800, lng: 120.647480},
                    streetViewControl: false
                });

                var infoWindow = new google.maps.InfoWindow();
                boothData.forEach(function (booth) {
                    var mapLabel = new MapLabel({
                        text: booth['name'],
                        position: new google.maps.LatLng(booth['latitude'], booth['longitude']),
                        map: map,
                        align: 'center',
                        strokeWeight: 0,
                    });

                    var rectangle = genRectangle(map, booth['latitude'], booth['longitude'], booth['fillColor']);

                    rectangle.addListener('click', (function (infoWindow) {
                        return function () {
                            var linkText = booth['url'] ? '<br/>' + '<a href="' + booth['url'] + '" target="_blank">了解更多...</a>' : '';
                            infoWindow.setContent(booth['club_name'] + linkText);
                            infoWindow.setPosition({lat: booth['latitude'], lng: booth['longitude']});
                            infoWindow.open(map);
                        };
                    })(infoWindow));
                });

                var polyline = new google.maps.Polyline({
                    clickable: false,
                    path: coordinates,
                    geodesic: true,
                    strokeColor: '#0000FF',
                    strokeOpacity: 0,
                    //strokeWeight: 3,
                    zIndex: 999,
                    icons: [{
                        icon: {
                            path: 'M 0,-2 0,2',
                            strokeOpacity: 1,
                            scale: 4
                        },
                        offset: '0',
                        repeat: '24px'
                    }]
                });

                for (var i = 0; i < polyline.getPath().getLength(); i++) {
                    var marker = new google.maps.Marker({
                        clickable: false,
                        icon: {
                            // use whatever icon you want for the "dots"
                            url: "//maps.gstatic.com/mapfiles/ridefinder-images/mm_20_white.png",
                            size: new google.maps.Size(12, 20),
                            anchor: new google.maps.Point(6, 20)
                        },
                        position: polyline.getPath().getAt(i),
                        map: map
                    });
                }

                polyline.setMap(map);

                animateLine(polyline);
            }

            /**
             * @see https://googlemaps.github.io/js-samples/symbols/polyline-symbols.html
             */
            function animateLine(line) {
                var count = 0;
                window.setInterval(function () {
                    if (count > 23) {
                        count = 0;
                    } else {
                        count += 2;
                    }
                    var icons = line.get('icons');
                    icons[0].offset = count + 'px';
                    line.set('icons', icons);
                }, 50);
            }

            /**
             * @param map google.maps.Map
             * @param longitude 緯度
             * @param latitude 經度
             */
            function genRectangle(map, longitude, latitude, fillColor) {
                var radius = 0.000017;
                return new google.maps.Rectangle({
                    strokeColor: fillColor,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: fillColor,
                    fillOpacity: 0.5,
                    map: map,
                    bounds: {
                        north: longitude + radius,
                        south: longitude - radius,
                        east: latitude + radius,
                        west: latitude - radius
                    }
                });
            }

            google.maps.event.addDomListener(window, 'load', initMap);
        </script>
    @endif
@endsection
