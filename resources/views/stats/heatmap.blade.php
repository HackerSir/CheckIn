@extends('layouts.app')

@section('title', '熱度地圖')

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
    <div class="mt-3 pb-3">
        <h1>熱度地圖</h1>
        <div class="mt-2" id="map"></div>
    </div>
@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ GoogleApi::getKey() }}&libraries=visualization"></script>
    <script src="{{ asset('js/maplabel-compiled.js') }}"></script>
    <script>
        var boothData = {!! json_encode($boothData) !!}
        var heatMapData = <?php echo $heatDataJson ?>
    </script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 19,
                center: {lat: 24.179800, lng: 120.647480},
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
                        var linkText = booth['url'] ? '<br/>' + '<a href="' + booth['url'] + '" target="_blank">了解更多...</a>' : '';
                        infoWindow.setContent(booth['club_name'] + linkText);
                        infoWindow.setPosition({lat: booth['latitude'], lng: booth['longitude']});
                        infoWindow.open(map);
                    };
                })(infoWindow));
            });

            var heatmap = new google.maps.visualization.HeatmapLayer({
                data: heatMapData,
                opacity: 1,
                radius: 40,
            });
            heatmap.setMap(map);
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
@endsection
