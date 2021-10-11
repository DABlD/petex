@extends('layouts.app')
@section('content')
    <section class="content">

      {{-- Boxes --}}
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>1</h3>

              <p>Ongoing Delivery</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>5</h3>

              <p>Deliveries Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>15</h3>

              <p>Total Transactions Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      @if(auth()->user()->role == "Rider")

        <div class="row">
          <section class="col-lg-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title" style="color: red;">No Delivery</h3>
              </div>

              <div class="box-body">
                  <div id="map" style="width: 100%; height: 50vh; position: block;"></div>
              </div>
              <div class="box-footer clearfix">
              </div>

            </div>
          </section>
        </div>

      @endif

    </section>
@endsection

@push('before-scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&libraries=places&callback=mapInit"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
@endpush

@push('after-scripts')
  <script>
    var map;
    var markers = [];
    var dlat = 0;
    var dlng = 0;
    var directionsService;
    var directionsRenderer;
    var distance;

    function mapInit(){
      @if(auth()->user()->role == "Rider")
        setTimeout(() => {
          navigator.geolocation.getCurrentPosition(position => {
              dlat = position.coords.latitude;
              dlng = position.coords.longitude;
              initMap(dlat, dlng);
          });
        }, 1000);
      @endif
    }

    function initMap(lat, lng){
      map = new google.maps.Map(document.getElementById("map"), {
          center: {lat: lat, lng: lng},
          zoom: 12,
      });

      directionsService = new google.maps.DirectionsService();
      directionsRenderer = new google.maps.DirectionsRenderer();
      distance = new google.maps.DistanceMatrixService();

      directionsRenderer.setMap(map);
      checkDelivery(map.center);
    }

    // CHECK IF THERE IS DELIVERY
    function checkDelivery(){
      markers.forEach((marker) => {
        marker.setMap(null);
      });
      markers = [];

      $.ajax({
        url: '{{ route('checkRiderDelivery') }}',
        success: result => {
          result = JSON.parse(result);

          if(result != null)
          {
            if(result.status == "Cancelled"){
              $('.box-title').html('Your last delivery was cancelled');
            }
            else{
              sloc = {
                lat: parseFloat(result.slat),
                lng: parseFloat(result.slng)
              };

              dloc = {
                lat: parseFloat(result.lat),
                lng: parseFloat(result.lng)
              }

              rloc = {
                lat: parseFloat(result.rlat),
                lng: parseFloat(result.rlng)
              }

              // IF PICKUP
              if(result.status == "For Pickup"){
                if(moment.duration(moment().diff(moment(result.created_at))).asSeconds() < 5)
                {
                  swal({
                    title: 'You have a new delivery!'
                  });
                }

                $('.box-title').html('For Pickup');
                showDirection(rloc, sloc);

                let dMarker = new google.maps.Marker({
                  position: dloc,
                  map,
                  label: {
                    color: 'white',
                    text: 'D'
                  }
                });

                markers.push(dMarker);
              }

              // IF FOR DELIVERY
              else if(result.status == "For Delivery"){
                $('.box-title').html('For Delivery');
                showDirection(rloc, dloc);
              }
            }
          }

          setTimeout(() => {
            checkDelivery();
          }, 5000);
        }
      });
    }

    function showDirection(origin, destination){
      let request = {
          origin: origin,
          destination: destination,
          travelMode: 'DRIVING'
      };

      directionsService.route(request, function(result, status) {
        if (status == 'OK') {
          directionsRenderer.setOptions({
              polylineOptions: {
                strokeColor: 'red'
              }
          }); 
          directionsRenderer.setDirections(result);
        }
      });
    }
  </script>
@endpush