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
    <div class="btn-group mt-2" role="group">
        <a class="btn btn-secondary">靜態地圖</a>
        <a class="btn btn-secondary">Google Map</a>
    </div>
    <div class="mt-2">
        <!--          Test code
         https://forum.gamer.com.tw/C.php?page=1&bsn=26742&snA=35764  -->
        <img src="http://i.imgur.com/9pHQGun.jpg" class="img-fluid" style="width: 100%">
    </div>
    <div class="mt-2" id="map"></div>
@endsection

@section('js')
    <script>
        function initMap() {
            var uluru = {lat: -25.363, lng: 131.044};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ GoogleApi::getKey() }}&callback=initMap">
    </script>
@endsection
