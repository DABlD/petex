@extends('layouts.app')
@section('content')
    <section class="content">

      {{-- Boxes --}}

      <div class="row">

        @if(auth()->user()->role == "Admin")
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
        @else
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>{{ $totalTransactions }}</h3>

                <p>Total Transactions</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
        @endif

        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $ongoing }}</h3>

              @if(auth()->user()->role != "Rider")
                <p>Ongoing Delivery</p>
              @else
                <p>Income Today</p>
              @endif
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

        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="pane-tab active"><a href="#asap" aria-controls="asap" role="tab" data-toggle="tab">ASAP</a></li>
          <li role="presentation" class="pane-tab"><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">Schedule</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="asap">
            @include('includes.asap')
          </div>
          <div role="tabpanel" class="tab-pane" id="schedule">
            @include('includes.schedule')
          </div>
        </div>

      @else

        <div class="row">
          <section class="col-lg-12">
            <div class="box box-info">

              <div class="box-header with-border">
                <div class="col-md-2">
                  <input type="text" id="from" placeholder="From" data-input>
                </div>
                <div class="col-md-2">
                  <input type="text" id="to" placeholder="To" data-input>
                </div>
                <div class="col-md-1">
                  <a class="btn btn-danger clear" data-toggle="tooltip" title="Clear">
                    <span class="fa fa-close"></span>
                  </a>
                </div>
              </div>

              <div class="box-body">
                
                <div class="col-md-12">
                  <canvas id="chart-1"></canvas>
                </div>

              </div>

              <div class="box-footer clearfix">
              </div>

            </div>
          </section>
        </div>

      @endif

    {{-- TABLE --}}
    @if(auth()->user()->role == "Admin")
      <div class="row">
      {{-- TABLE --}}
      <section class="col-lg-6">
        <div class="box box-info">

          <div class="box-header with-border">
            Income Table
          </div>

          <div class="box-body">
            <table class="table table-hover table-bordered" id="table" style="width: 100%;">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Income</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

          <div class="box-footer clearfix">
          </div>

        </div>
      </section>

      {{-- PIE CHART --}}
      <section class="col-lg-6">
        <div class="box box-info">

          <div class="box-header with-border">
            Pie Chart
          </div>

          <div class="box-body">
            <div class="box-body col-md-2"></div>
            <div class="box-body col-md-6">
              <canvas id="chart-2"></canvas>
            </div>
            <div class="box-body col-md-4"></div>
          </div>

          <div class="box-footer clearfix">
          </div>

        </div>
      </section>

      <section class="col-lg-12">
        <div class="box box-info">

          <div class="box-header with-border">
            Heatmap of Cancelled Bookings

            <div class="pull-right">
              <button class="btn-info" onclick="toggle()">Toggle</button>
            </div>
          </div>

          <div class="box-body">
            <div class="box-body">
                <div id="map" style="width: 100%; height: 80vh; position: block;"></div>
            </div>
          </div>

          <div class="box-footer clearfix">
          </div>

        </div>
      </section>
      </div>
    @endif

    </section>
@endsection

@push('after-styles')
  <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
  <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endpush

@push('before-scripts')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&libraries=places&libraries=visualization&callback=mapInit"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/charts.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
@endpush

@push('after-scripts')
  <script>
    @if(auth()->user()->role == "Rider")
      var map;
      var markers = [];
      var dlat = 0;
      var dlng = 0;
      var directionsService;
      var directionsRenderer;
      var distance;

      function mapInit(){
        @if(auth()->user()->role == "Rider")
        console.log('asd');
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

        let cur = new google.maps.Marker({
          position: {lat: lat, lng: lng},
          map,
        });

        markers.push(cur);

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
                if(result != "null"){
                    result = JSON.parse(result);

                    $('.sname').parent().addClass('hidden');
                    $('.scontact').parent().addClass('hidden');

                    $('.delivery').data('id', result.id);
                    $('.delivery').addClass('hidden');

                    $('.cancelBooking').data('id', result.id);
                    $('.pickedUp').data('id', result.id);

                    if(result != null)
                    {
                      $('.comments').html("N/A");
                      console.log(result.status, "status");
 
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
                      
                      if(result.status == "Finding Driver"){
                          swal({
                              title: 'Would you like to accept this booking?',
                              html: `
                                <h4>
                                Name: ${result.fname} ${result.lname}<br>
                                Price: ₱${result.price.toFixed(2)}<br>
                                Address: ${result.address}<br>
                                ETA: <span id="eta"></span>

                                <br>
                                <br>

                                <div id="map2" style="width: 100%; height: 50vh;"></div>
                                </h4>
                              `,
                              showCancelButton: true,
                              cancelButtonText: 'Decline',
                              confirmButtonText: 'Accept',
                              cancelButtonColor: '#f76c6b',
                              width: '80vh',
                              allowOutsideClick: false,
                              onOpen: () => {
                                  $('#swal2-content').css({
                                      "text-align": "left",
                                      "padding-left": '30px'
                                  })

                                  map = new google.maps.Map(document.getElementById("map2"), {
                                      center: rloc,
                                      zoom: 12,
                                  });

                                  let dMarker = new google.maps.Marker({
                                    position: dloc,
                                    map,
                                    label: {
                                      color: 'white',
                                      text: 'C'
                                    },
                                  });

                                  directionsService2 = new google.maps.DirectionsService();
                                  directionsRenderer2 = new google.maps.DirectionsRenderer();

                                  directionsRenderer2.setMap(map);

                                  let request2 = {
                                      origin: rloc,
                                      destination: sloc,
                                      travelMode: 'DRIVING'
                                  };
                                  directionsService2.route(request2, function(result, status) {
                                    if (status == 'OK') {
                                      directionsRenderer2.setOptions({
                                          polylineOptions: {
                                            strokeColor: 'red'
                                          }
                                      }); 
                                      directionsRenderer2.setDirections(result);
                                    }
                                  });

                                  // DISTANCE
                                  distance.getDistanceMatrix({
                                    origins: [sloc],
                                    destinations: [dloc],
                                    travelMode: 'DRIVING',
                                  }, callback);

                                  function callback(response, status) {
                                    eta = response.rows[0].elements[0].duration.value;

                                    // DISTANCE
                                    distance.getDistanceMatrix({
                                      origins: [rloc],
                                      destinations: [sloc],
                                      travelMode: 'DRIVING',
                                    }, callback2);

                                    function callback2(response, status) {
                                      eta2 = response.rows[0].elements[0].duration.value;
                                      console.log(Math.ceil((eta + eta2) / 60) + " min");
                                      $('#eta').html(Math.ceil((eta + eta2) / 60) + " min");
                                    }
                                  }
                              }
                          }).then(choice => {
                              if(choice.dismiss == "cancel"){
                                $.ajax({
                                  url: '{{ route('updateStatus') }}',
                                  data: {
                                    id: result.id,
                                    status: 'To Process',
                                    tid: null
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
                              }
                              else if(choice.value){
                                $.ajax({
                                  url: '{{ route('updateStatus') }}',
                                  data: {
                                    id: result.id,
                                    status: 'For Pickup',
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
                              }

                              checkDelivery();
                          });
                      }
                      else if(result.status == "Cancelled"){
                        $('.box-title').html('Your last delivery was cancelled');
                            $('.comments').html('');
                      }
                      else if(result.status != "Rider Cancel"){
                        $('.sname').html(result.sfname + " " + result.slname);
                        $('.scontact').html(result.scontact);
                        $('.sname').parent().removeClass('hidden');
                        $('.scontact').parent().removeClass('hidden');

                        if(result.comments != ""){
                          $('.comments').html(result.comments);
                        }

                        // IF PICKUP
                        if(result.status == "For Pickup"){
                            $('.pickedUp').removeClass('hidden');
                          $('.cancelBooking').removeClass('hidden');
                          if(moment.duration(moment().diff(moment(result.created_at))).asSeconds() < 7)
                          {
                            swal({
                              title: 'You have a new delivery!'
                            });
                          }

                          $('.box-title').html('For Pickup');
                          showDirection(rloc, sloc);

                          // let dMarker = new google.maps.Marker({
                          //   position: dloc,
                          //   map,
                          //   label: {
                          //     color: 'white',
                          //     text: 'D'
                          //   }
                          // });

                          // markers.push(dMarker);
                        }

                        // IF FOR DELIVERY
                        else if(result.status == "For Delivery"){
                          $('.box-title').html('For Delivery');
                          showDirection(rloc, dloc);
                          $('.delivery').removeClass('hidden');
                          $('.pickedUp').addClass('hidden');
                          $('.cancelBooking').addClass('hidden');
                        }
                        else if(result.status == "Rider Cancel"){
                            $('.comments').html('');
                          $('.pickedUp').addClass('hidden');
                          $('.cancelBooking').addClass('hidden');
                        }
                        else if (result.status == "Delivered"){
                            
                            $('.sname').parent().addClass('hidden');
                            $('.scontact').parent().addClass('hidden');
                            $('.comments').html('');
                        }
                      }
                    }

                    setTimeout(() => {
                      if(!$('#swal2-content').is(":visible")){
                        checkDelivery();
                      }
                    }, 7000);
                  }
                  else{
                    // IF NOT ASAP, CHECK SCHEDULED
                    $.ajax({
                      url: '{{ route('checkRiderDelivery2') }}',
                      success: result => {

                        console.log(result, result != "null");
                        if(result != "null"){
                          result = JSON.parse(result);

                          if(true){
                            $('.comments').html("N/A");

                            
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

                            console.log(sloc);
                            console.log(dloc);
                            console.log(rloc);

                            if(result.status == "Finding Driver"){
                                swal({
                                    title: 'Would you like to accept this scheduled booking?',
                                    html: `
                                      <h4>
                                      Name: ${result.fname} ${result.lname}<br>
                                      Price: ₱${result.price.toFixed(2)}<br>
                                      Address: ${result.address}<br>
                                      Schedule: ${moment(result.schedule).format("MMM DD, YYYY hh:mm A")}<br><br>
                                      <span style="color:red;"><b>NOTE:</b> You will not be able to accept a booking 1 hour before this scheduled booking.</span>

                                      <br>
                                      <br>

                                      <div id="map2" style="width: 100%; height: 50vh;"></div>
                                      </h4>
                                    `,
                                    showCancelButton: true,
                                    cancelButtonText: 'Decline',
                                    confirmButtonText: 'Accept',
                                    cancelButtonColor: '#f76c6b',
                                    width: '80vh',
                                    allowOutsideClick: false,
                                    onOpen: () => {
                                        $('#swal2-content').css({
                                            "text-align": "left",
                                            "padding-left": '30px'
                                        })

                                        map = new google.maps.Map(document.getElementById("map2"), {
                                            center: rloc,
                                            zoom: 12,
                                        });

                                        let dMarker = new google.maps.Marker({
                                          position: dloc,
                                          map,
                                          label: {
                                            color: 'white',
                                            text: 'C'
                                          },
                                        });

                                        directionsService2 = new google.maps.DirectionsService();
                                        directionsRenderer2 = new google.maps.DirectionsRenderer();

                                        directionsRenderer2.setMap(map);

                                        let request2 = {
                                            origin: rloc,
                                            destination: sloc,
                                            travelMode: 'DRIVING'
                                        };
                                        directionsService2.route(request2, function(result, status) {
                                          if (status == 'OK') {
                                            directionsRenderer2.setOptions({
                                                polylineOptions: {
                                                  strokeColor: 'red'
                                                }
                                            }); 
                                            directionsRenderer2.setDirections(result);
                                          }
                                        });

                                        // DISTANCE
                                        distance.getDistanceMatrix({
                                          origins: [sloc],
                                          destinations: [dloc],
                                          travelMode: 'DRIVING',
                                        }, callback);

                                        function callback(response, status) {
                                          eta = response.rows[0].elements[0].duration.value;

                                          // DISTANCE
                                          distance.getDistanceMatrix({
                                            origins: [rloc],
                                            destinations: [sloc],
                                            travelMode: 'DRIVING',
                                          }, callback2);

                                          function callback2(response, status) {
                                            eta2 = response.rows[0].elements[0].duration.value;
                                            console.log(Math.ceil((eta + eta2) / 60) + " min");
                                            $('#eta').html(Math.ceil((eta + eta2) / 60) + " min");
                                          }
                                        }
                                    }
                                }).then(choice => {
                                    if(choice.dismiss == "cancel"){
                                      $.ajax({
                                        url: '{{ route('updateStatus') }}',
                                        data: {
                                          id: result.id,
                                          status: 'To Process',
                                          tid: null
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
                                    }
                                    else if(choice.value){
                                      $.ajax({
                                        url: '{{ route('updateStatus') }}',
                                        data: {
                                          id: result.id,
                                          status: 'For Pickup',
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
                                    }

                                    checkDelivery();
                                });
                            }
                            else if(result.status == "Cancelled"){
                              $('.box-title').html('Your last delivery was cancelled');
                                  $('.comments').html('');
                            }
                            else if(result.status != "Rider Cancel"){
                              $('.sname').html(result.sfname + " " + result.slname);
                              $('.scontact').html(result.scontact);
                              $('.sname').parent().removeClass('hidden');
                              $('.scontact').parent().removeClass('hidden');

                              if(result.comments != ""){
                                $('.comments').html(result.comments);
                              }

                              // IF PICKUP
                              if(result.status == "For Pickup"){
                                  $('.pickedUp').removeClass('hidden');
                                $('.cancelBooking').removeClass('hidden');
                                if(moment.duration(moment().diff(moment(result.created_at))).asSeconds() < 7)
                                {
                                  swal({
                                    title: 'You have a new delivery!'
                                  });
                                }

                                $('.box-title').html('For Pickup');
                                showDirection(rloc, sloc);

                                // let dMarker = new google.maps.Marker({
                                //   position: dloc,
                                //   map,
                                //   label: {
                                //     color: 'white',
                                //     text: 'D'
                                //   }
                                // });

                                // markers.push(dMarker);
                              }

                              // IF FOR DELIVERY
                              else if(result.status == "For Delivery"){
                                $('.box-title').html('For Delivery');
                                showDirection(rloc, dloc);
                                $('.delivery').removeClass('hidden');
                                $('.pickedUp').addClass('hidden');
                                $('.cancelBooking').addClass('hidden');
                              }
                              else if(result.status == "Rider Cancel"){
                                  $('.comments').html('');
                                $('.pickedUp').addClass('hidden');
                                $('.cancelBooking').addClass('hidden');
                              }
                              else if (result.status == "Delivered"){
                                  $('.sname').parent().addClass('hidden');
                                  $('.scontact').parent().addClass('hidden');
                                  $('.comments').html('');
                              }
                            }
                          }
                        }

                        

                        setTimeout(() => {
                          if(!$('#swal2-content').is(":visible")){
                            checkDelivery();
                          }
                        }, 7000);
                      }

                    });
                  }
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

        let id = $(elem.target).data('id');

        swal({
          title: 'Proof of delivery',
          input: 'file',
          showCancelButton: true,
          cancelButtonColor: '#f76c6b',
        }).then(result => {
          if(result.value){
            $('.delivery').addClass('hidden');
            SavePhoto(result.value, id)
          }
        });
      });

      async function SavePhoto(photo, id) 
      {
          let formData = new FormData();
               
          formData.append("proof", photo);
          formData.append("id", id); 
          formData.append("_token", "{{ csrf_token() }}"); 
          
          const ctrl = new AbortController()    // timeout
          setTimeout(() => ctrl.abort(), 5000);
          
          try {
             let r = await fetch('{{ route('uploadProof') }}', 
               {method: "POST", body: formData, signal: ctrl.signal}); 
             console.log('HTTP response code:',r.status);


            setTimeout(() => {
              swal({
                type: 'success',
                title: 'Success',
                text: 'Completed!',
                showConfirmButton: false,
                timer: 2000
              });
            });
          } catch(e) {
             console.log('Huston we have problem...:', e);
          }
      }

      $('.cancelBooking').on('click', elem => { 

        swal({
          type: 'warning',
          title: 'Are you sure you want to decline?',
          showCancelButton: true,
          cancelButtonColor: '#f76c6b',
        }).then(result => {
          if(result.value){
            swal('Processing');
            swal.showLoading();

            $('.cancelBooking').addClass('hidden');
            $.ajax({
              url: '{{ route('updateStatus') }}',
              data: {
                id: $(elem.target).data('id'),
                status: 'Rider Cancel',
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
          }
        })
      });

      $('.pickedUp').on('click', elem => { 

        swal({
          type: 'info',
          title: 'Confirmation',
          showCancelButton: true,
          cancelButtonColor: '#f76c6b',
        }).then(result => {
          if(result.value){
            swal('Processing');
            swal.showLoading();

            let id = $(elem.target).data('id');

            $.ajax({
              url: "{{ route('updateStatus') }}",
              data: {
                id: id,
                status: 'For Delivery',
                pickup_time: moment().format('Y-MM-DD H:m:s')
              },
              success: result => {
                swal({
                  type: 'success',
                  title: 'Success',
                  text: 'Completed!',
                  showConfirmButton: false,
                  timer: 2000
                });
              }
            })
          }
        })
      });
    @else
      function mapInit(){
        console.log('!rider');
        @if(auth()->user()->role == "Admin")
          setTimeout(() => {
            navigator.geolocation.getCurrentPosition(position => {
                dlat = position.coords.latitude;
                dlng = position.coords.longitude;
                initMap2(dlat, dlng);
            });
          }, 2000);
        @endif
      }
      
      @if(auth()->user()->role == "Admin")

      var heatmap;
      var data = [];
      const gradient = [
        "rgba(0, 255, 255, 0)",
        "rgba(0, 255, 255, 1)",
        "rgba(0, 191, 255, 1)",
        "rgba(0, 127, 255, 1)",
        "rgba(0, 63, 255, 1)",
        "rgba(0, 0, 255, 1)",
        "rgba(0, 0, 223, 1)",
        "rgba(0, 0, 191, 1)",
        "rgba(0, 0, 159, 1)",
        "rgba(0, 0, 127, 1)",
        "rgba(63, 0, 91, 1)",
        "rgba(127, 0, 63, 1)",
        "rgba(191, 0, 31, 1)",
        "rgba(255, 0, 0, 1)",
      ];

      data["selected"] = "data1";
      data['data1'] = [];
      data['data2'] = [];

      function initMap2(lat, lng){
        map = new google.maps.Map(document.getElementById("map"), {
            center: {lat: lat, lng: lng},
            zoom: 12,
        });
        let cancelled = JSON.parse("{{ $all_cancelled }}".replace(/&quot;/g,'"'));
        let delivered = JSON.parse("{{ $all_delivered }}".replace(/&quot;/g,'"'));

        cancelled.forEach(a => {
          data["data1"].push(new google.maps.LatLng(a.lat, a.lng));
        });

        delivered.forEach(a => {
          data["data2"].push(new google.maps.LatLng(a.lat, a.lng));
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: data[data['selected']],
          radius: 50
        });
        heatmap.setMap(map);
      }

      function toggle(){
        data["selected"] = data["selected"] == "data1" ? "data2" : "data1";
        heatmap.set('gradient', heatmap.get("gradient") ? null : gradient);
        heatmap.set('data', data[data["selected"]]);
      }
      
      @endif

      function setDates(){
        $('#from, #to').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });
      } 
      setDates();

      $('.clear').click(() => {
        setDates();
      });

      // CHARTS
      $('#table').DataTable();
      var chart = new Chart(
        document.getElementById('chart-1'),
        {
           type: 'line',
           data: {
             labels: [],
             datasets: [{
               label: "Number of Transactions from selected date range",
               backgroundColor: 'rgb(255, 99, 132)',
               borderColor: 'rgb(255, 99, 132)',
               data: []
             }]
           },
           options: {
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1,
                  maxTicksLimit: 5
                }
              }
            }
           }
         }
      );

      var chart2 = new Chart(
      document.getElementById('chart-2'),
      {
         type: 'pie',
         data: {
           labels: ["Delivered", "Cancelled", "Rider Cancel"],
           datasets: [{
             label: "Transaction Status",
             backgroundColor: [
               'rgb(255, 99, 132)',
               'rgb(54, 162, 235)',
               'rgb(255, 205, 86)'
             ],
             hoverOffset: 4,
             data: [0,0,0]
           }]
         },
       }
      );

      $('#from, #to').change(e => {
        let init = true;
        let from = $('#from').val();
        let to = $('#to').val();

        from = to != "" ? from != "" ? from : to : from;
        to = "" ? moment().format("YYYY-MM-DD") : to;

        $.ajax({
          url: '{{ route('getData') }}',
          data: {
            from: from,
            to: to
          },
          success: result => {
            result = JSON.parse(result);
            console.log(result);
            transactions = result.transactions;
            result = result.labels;
            let label = init? "Past week income" : moment(from).format("MMM DD, YYYY") + " - " + moment(to).format("MMM DD, YYYY");

            // LINE CHART DATA
            chart.config.data.labels = Object.keys(result);
            chart.config.data.datasets[0].label = label;
            chart.config.data.datasets[0].data = Object.values(result);
            chart.update();

            // PIE CHART DATA
            let status = [];
            status["Delivered"] = 0;
            status["Cancelled"] = 0;
            status["Rider Cancel"] = 0;
            status["No Delivery"] = 0;

            transactions.forEach(row => {
              status[row.status]++;
            });
            chart2.config.data.datasets[0].data = [status["Delivered"], status["Cancelled"], status["Rider Cancel"]];
            chart2.update();

            $('#table').DataTable().destroy();
            // TABLE DATA
            let tableString = "";
            let prices = [];
            Object.keys(result).forEach(date => {
              prices[date] = parseFloat(0);
              tableString += `
                <tr>
                  <td>${date}</td>
                  <td id="${date}"></td>
                </tr>
              `;
            });
            $('#table tbody').html(tableString);

            transactions.forEach(transaction => {
              if(transaction.status == "Delivered"){
                let date = moment(transaction.created_at).format('MMM D, YY');
                prices[date] += parseFloat(transaction.price);
              }
            });

            Object.keys(result).forEach(date => {
              $(`[id="${date}"]`).html(parseFloat(prices[date] * .75).toFixed(2));
            });
            
            $('#table').DataTable();
          }
        });
      });
    @endif
  </script>
@endpush