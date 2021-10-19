@extends('admin.layout.default')
@section('css')
<style>
#map-layer {
	margin: 20px 0px;
	max-width: 600px;
	max-height: 400;
}
#btnAction {
	background: #3878c7;
    padding: 10px 40px;
    border: #3672bb 1px solid;
    border-radius: 2px;
    color: #FFF;
    font-size: 0.9em;
    cursor:pointer;
    display:block;
}
#btnAction:disabled {
    background: #6c99d2;
}
</style>
@endsection

@section('jsPostApp')
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu8j0A78kPx4g_fKslJuBIQAigk5qPGlg&callback=initMap"
	async defer></script>

<script type="text/javascript">
 /*   var map;
    function initMap() {
        var mapLayer = document.getElementById("map-layer");
        var centerCoordinates = new google.maps.LatLng(37.6, -95.665);
        var defaultOptions = { center: centerCoordinates, zoom: 4 }

        map = new google.maps.Map(mapLayer, defaultOptions);
    }*/
    var  n = 0;
    var locations = [
            ['Raj Ghat', 28.648608, 77.250925, 1],
            ['Purana Qila', 28.618174, 77.242686, 2],
            ['Red Fort', 28.663973, 77.241656, 3],
            ['India Gate', 28.620585, 77.228609, 4],
            ['Jantar Mantar', 28.636219, 77.213846, 5],
            ['Akshardham', 28.622658, 77.277704, 6]
        ];
    var map
    function initMap() {
        var mapProp= {
            center:new google.maps.LatLng(64.1376866, -21.9366231),
            zoom:13,
        };
        map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
    setInterval(() => {
        $.ajax({
            type:'get',
            url:'/admin/getdriver',
            success:function(response) {           
                var drivers = JSON.parse(response);
                for (var i = 0; i < drivers.length; i++) {
                    locations[i][0] = drivers[i].name;
                    locations[i][1] = drivers[i].lat;
                    locations[i][2] = drivers[i].long;
                }
                n = drivers.length;
                locates();
            },
            failure:function(e){
                console.log(e);
            }
        })
    }, 5000);
    function locate(){
        document.getElementById("btnAction").disabled = true;
        document.getElementById("btnAction").innerHTML = "Processing...";
        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){ 
                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;

                var infoWindowHTML = "Latitude: " + currentLatitude + "<br>Longitude: " + currentLongitude;
                var infoWindow = new google.maps.InfoWindow({map: map, content: infoWindowHTML});
                var currentLocation = { lat: currentLatitude, lng: currentLongitude };
                infoWindow.setPosition(currentLocation);
                document.getElementById("btnAction").style.display = 'none';
            });
        }
    }
    function locates(){
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < n; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }
/*    var locations = [
            ['Raj Ghat', 28.648608, 77.250925, 1],
            ['Purana Qila', 28.618174, 77.242686, 2],
            ['Red Fort', 28.663973, 77.241656, 3],
            ['India Gate', 28.620585, 77.228609, 4],
            ['Jantar Mantar', 28.636219, 77.213846, 5],
            ['Akshardham', 28.622658, 77.277704, 6]
        ];
    function InitMap() {
        var map = new google.maps.Map(document.getElementById('googleMap'), {
            zoom: 13,
            center: new google.maps.LatLng(28.614884, 77.208917),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }*/
</script>
@endsection

@section('content')
<div class="main-container">
    <div class="row">
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign success-text">person</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{$data->driver}}</div>
                        <p>Total Drivers</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign primary-text">supervisor_account</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{ $data->adminCount }}</div>
                        <p>Administrators</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign warning-text">accessibility</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{$data->tourCount}}</div>
                        <p>Total Tours</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card horizontal">
                <div class="card-image valign-wrapper pad-lr-20">
                    <i class="material-icons medium valign success-text">fingerprint</i>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <div class="card-title" style="font-weight:bold;">{{$data->passengerCount}}</div>
                        <p>Total Passengers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="button-layer">
        <button id="btnAction" onClick="locates()">My Current Location</button>
    </div>
    <div id="googleMap" style="width:100%;height:700px;"></div>
</div>
@endsection
