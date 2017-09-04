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
                <a href="https://i.imgur.com/ApFAAK9.jpg" target="_blank">
                    <img src="https://i.imgur.com/ApFAAK9.jpg" class="img-fluid" style="width: 100%">
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

                var rectangle = genRectangle(map, 24.179976, 120.648279);

                rectangle.addListener('click', function () {
                    window.open('https://www.google.com', '_blank');
                });
            }

            /**
             * @param map google.maps.Map
             * @param longitude 緯度
             * @param latitude 經度
             */
            function genRectangle(map, longitude, latitude) {
                var radius = 0.00002;
                return new google.maps.Rectangle({
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#0000FF',
                    fillOpacity: 0.35,
                    map: map,
                    bounds: {
                        north: longitude + radius,
                        south: longitude - radius,
                        east: latitude + radius,
                        west: latitude - radius
                    }
                });
            }

        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key={{ GoogleApi::getKey() }}&callback=initMap">
        </script>
    @endif
@endsection
