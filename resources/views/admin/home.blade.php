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
    var map
    function initMap() {
        var mapProp= {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:15,
        };
        map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
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
     /*   if (navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(function(position) {  

                var point = new google.maps.LatLng(position.coords.latitude, 
                                                position.coords.longitude);

                // Initialize the Google Maps API v3
                var map = new google.maps.Map(document.getElementById('googleMap'), {
                    zoom: 15,
                    center: point,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                // Place a marker
                new google.maps.Marker({
                    position: point,
                    map: map
                });
            }); 
        } 
        else {
            alert('W3C Geolocation API is not available');
        } */
    }
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
        <button id="btnAction" onClick="locate()">My Current Location</button>
    </div>
    <div id="googleMap" style="width:100%;height:400px;"></div>
</div>
@endsection
