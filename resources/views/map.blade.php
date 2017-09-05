@extends('layouts.app')

@section('title', '攤位地圖')

@section('css')
    <style>
        #map {
            width: 100%;
            height: 70vh;
        }

        @media (max-width: 576px) {
            body > .container {
                padding-left: 0;
                padding-right: 0;
            }
        }

        a {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="mt-2 pb-2">
        <div class="btn-group" role="group">
            <a href="{{ route('clubs.map', ['type' => 'static']) }}"
               class="btn btn-secondary @if ($type == 'static') active @endif">靜態地圖</a>
            <a href="{{ route('clubs.map', ['type' => 'google']) }}"
               class="btn btn-secondary @if ($type == 'google') active @endif">Google Map</a>
        </div>
        @if ($type == 'static')
            <div class="mt-2">
                <a href="https://i.imgur.com/PHKhyiI.jpg" target="_blank">
                    <img src="https://i.imgur.com/PHKhyiI.jpg" class="img-fluid" style="width: 100%">
                </a>
            </div>
            <div class="mt-2">
                <a href="https://i.imgur.com/cNFhz8K.jpg" target="_blank">
                    <img src="https://i.imgur.com/cNFhz8K.jpg" class="img-fluid" style="width: 100%">
                </a>
            </div>
        @endif
        @if ($type == 'google')
            <div class="mt-2" id="map"></div>
        @endif
    </div>
@endsection

@section('js')
    @if ($type == 'google')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ GoogleApi::getKey() }}"></script>
        <script src="{{ asset('js/maplabel-compiled.js') }}"></script>
        <script>
            var boothData = {!! json_encode($boothData) !!}
        </script>
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 19,
                    center: {lat: 24.179976, lng: 120.648279},
                    streetViewControl: false
                });

                var myloc = new google.maps.Marker({
                    clickable: false,
                    icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
                        new google.maps.Size(22, 22),
                        new google.maps.Point(0, 18),
                        new google.maps.Point(11, 11)),
                    shadow: null,
                    zIndex: 999,
                    map: map
                });

                if (navigator.geolocation) navigator.geolocation.getCurrentPosition(function (pos) {
                    var me = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
                    myloc.setPosition(me);
                }, function (error) {
                    // ...
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
                            infoWindow.setContent(booth['club_name'] + '<br>' + '<a href="' + booth['url'] + '" target="_blank">了解更多...</a>');
                            infoWindow.setPosition({lat: booth['latitude'], lng:  booth['longitude']});
                            infoWindow.open(map);
                        };
                    })(infoWindow));
                });
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
