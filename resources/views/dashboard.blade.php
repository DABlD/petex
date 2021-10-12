@extends('layouts.app')
@section('content')
    <section class="content">

      {{-- Boxes --}}
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $users }}</h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $ongoing }}</h3>

              <p>Ongoing Delivery</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $deliveries }}</h3>

              <p>Deliveries Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $cancelled }}</h3>

              <p>Cancelled Deliveries Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>
      </div>

      @if(auth()->user()->role == "Rider")

        <div class="row">
          <section class="col-lg-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <h3 class="box-title" style="color: red;">No Delivery</h3>
                <div class="pull-right">
                   <a class="btn btn-success hidden delivery" data-toggle="tooltip" title="Complete Delivery" data-id="">
                    <span class="fa fa-thumbs-up delivery" data-id=""></span>
                  </a>
                </div>
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

      navigator.geolocation.getCurrentPosition(position => {
          rlat = position.coords.latitude;
          rlng = position.coords.longitude;

          markers.forEach((marker) => {
            marker.setMap(null);
          });
          markers = [];

          $.ajax({
            url: '{{ route('checkRiderDelivery') }}',
            success: result => {
              result = JSON.parse(result);

              $('.delivery').data('id', result.id);
              $('.delivery').addClass('hidden');

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
                    lat: parseFloat(rlat),
                    lng: parseFloat(rlng)
                  }

                  // IF PICKUP
                  if(result.status == "For Pickup"){
                    if(moment.duration(moment().diff(moment(result.created_at))).asSeconds() < 7)
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
                    $('.delivery').removeClass('hidden');
                  }
                }
              }

              setTimeout(() => {
                checkDelivery();
              }, 5000);
            }
          });
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

    $('.delivery').on('click', elem => { 
      swal('Processing');
      swal.showLoading();

      $('.delivery').addClass('hidden');

      $.ajax({
        url: '{{ route('updateStatus') }}',
        data: {
          id: $(elem.target).data('id'),
          status: 'Delivered',
          delivery_time: moment().format('Y-MM-DD H:m:s')
        },
        success: result => {
          setTimeout(() => {
            swal({
              type: 'success',
              title: 'Success',
              text: 'Completed!',
              showConfirmButton: false,
              timer: 2000
            });
          });
        }
      });

    });
  </script>
@endpush