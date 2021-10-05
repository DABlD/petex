<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Dento - Dentist &amp; Medical HTML Template">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>PetEx - Pet Transportation</title>
        {{-- <link rel="icon" href="images/favicon.png"> --}}
        <link rel="stylesheet" href="css/homepage/style.css">
        <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}"></script>

        <style>
            .invalid-feedback{
                color: red;
            }

            .hidden{
                visibility: hidden;
            }

            .pac-container {
                z-index: 9999;
            }

            .pac-card {
              background-color: #fff;
              border: 0;
              border-radius: 2px;
              box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
              margin: 10px;
              padding: 0 0.5em;
              font: 400 18px Roboto, Arial, sans-serif;
              overflow: hidden;
              font-family: Roboto;
              padding: 0;
            }

            #pac-container {
              padding-bottom: 12px;
              margin-right: 12px;
            }

            .pac-controls {
              display: inline-block;
              padding: 5px 11px;
            }

            .pac-controls label {
              font-family: Roboto;
              font-size: 13px;
              font-weight: 300;
            }

            #pac-input {
              background-color: #fff;
              font-family: Roboto;
              font-size: 15px;
              font-weight: 300;
              margin-left: 12px;
              padding: 0 11px 0 13px;
              text-overflow: ellipsis;
            width: 50%;
            margin-top: 18px;
            }

            #pac-input:focus {
              border-color: #4d90fe;
            }

            .b1{
                background-color: #f76c6b;
                border: #f76c6b;
            }
        </style>
    </head>
    <body>
        <div id="preloader">
            <div class="preload-content">
                <div id="dento-load"></div>
            </div>
        </div>
        <header class="header-area">
            <div class="main-header-area">
                <div class="classy-nav-container breakpoint-off">
                    <div class="container">
                        <nav class="classy-navbar justify-content-between" id="dentoNav">
                            <a href="/" class="nav-brand">
                                <img src="images/logo1.png" alt="Logo" style="width: 200px; height: 60px;">
                            </a>
                            
                            <div class="classy-navbar-toggler">
                                <span class="navbarToggler"><span></span><span></span><span></span></span>
                            </div>
                            <div class="classy-menu">
                                <div class="classycloseIcon">
                                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                                </div>
                                <div class="classynav">
                                    <ul id="nav">
                                        <li>
                                            <a href="#" class="btn dento-btn booking-btn submit3">Sign In</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
        </nav>
    </div>
</div>
</div>
</header>


<!-- CONTACT -->
<section class="book-an-oppointment-area section-padding-100 bg-img bg-gradient-overlay jarallax clearfix" style="background-image:url(images/contact-us-background.jpg); padding-bottom: 0px; background-size: cover;" id="contact">
    <div class="container" style="max-width: 80%; height: 700px;">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center white">
                    <h2>Booking Details</h2>
                    <div class="line"></div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="appointment-form">
                    <form method="POST" action="{{ route('register') }}" id="registerForm" style="color: white;">
                        @csrf

                        <div class="row" style="height: 100%;">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <select name="sid" id="sid" class="form-control puwy">
                                        <option value="">Select Seller</option>
                                        @foreach($sellers as $seller)
                                            <option value="{{ $seller->id }}">{{ $seller->fname }} {{ $seller->lname }}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="sidError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <input type="text" class="form-control puwy" name="fname" placeholder="Enter First Name" autofocus>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="fnameError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <input type="text" class="form-control puwy" name="lname" placeholder="Enter Last Name">
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="lnameError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <input type="text" class="form-control puwy" name="contact" placeholder="Enter Contact Number">
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="contactError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="col-md-12">
                                    <input type="text" class="form-control puwy" id="address" name="address" placeholder="Select Address from Map" readonly>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="addressError"></strong>
                                    </span>
                                </div>

                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                            </div>

                            <div class="col-md-8" style="border: white;">
                                <input id="pac-input" class="control" type="text" placeholder="Search Box"/>
                                <div id="map" style="height: 100%; width: 100%;"></div>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <p style="color: white; margin-bottom: 0px;">
                                    Base Fare:  
                                </p>
                                <p style="color: white; margin-bottom: 0px;">
                                    Over Mileage(2km Base Distance):  
                                </p>
                                <p style="color: white; margin-bottom: 0px;">
                                    Total:  
                                </p>
                            </div>
                            <div class="col-md-1">
                                <p style="color: white; margin-bottom: 0px;">
                                    &#8369;50.00
                                </p>
                                <p style="color: white; margin-bottom: 0px;">
                                    &#8369;<span id="overM">0.00</span> (Distance: <span id="distance">0.0</span> KM)
                                </p>
                                <p style="color: white; margin-bottom: 0px;">
                                    &#8369;<span id="total">50.00</span>
                                </p>
                            </div>
                            <div class="col-md-8"></div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-5"></div>
                            <div class="col-md-2">
                                <button type="button" class="btn dento-btn booking-btn b1" onclick="calculate()">Calculate Price</button>
                                <button type="button" class="btn dento-btn booking-btn b2">Book</button>
                            </div>
                            <div class="col-md-5"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    </br>
    <div class="copywrite-content">
    <p>
        Copyright &copy;<script data-cfasync="false" src="js/homepage/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved
    </p>
    </div>

</section>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/swal.js') }}"></script>
<script src="{{ asset('js/homepage/dento.bundle.js') }}"></script>
<script src="{{ asset('js/homepage/active.js') }}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&libraries=places&callback=mapInit"></script>

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&callback=initMap&v=weekly" async></script> --}}

    <script>
        $('#sid').select2();

        let bool;

        // VALIDATE ON SUBMIT
        $('.submit').click(e => {
            $('#role').val($(e.target).data('id'));

            let inputs = $('.puwy:not(".input")');
            
            swal('Validating');
            swal.showLoading();

            $.each(inputs, (index, input) => {
                let temp = $(input);
                let error = $('#' + temp.attr('name') + 'Error');
                bool = false;

                if(input.value == ""){
                    showError(input, temp, error, 'This field is required');
                }
                else if(input.type == 'email'){
                    $.ajax({
                        url: '{{ url('validate') }}',
                        data: {
                            email: input.value,
                            rules: 'email|unique:users'
                        },
                        success: result => {
                            result = JSON.parse(result);
                            if(typeof result[temp.attr('name')] != 'undefined'){
                                showError(input, temp, error, result[temp.attr('name')][0]);
                            }
                        }
                    });
                }
                else if(temp.attr('name') == 'contact'){
                    if(!/^[0-9]*$/.test(input.value)){
                        showError(input, temp, error, 'Invalid Contact Number');
                    }
                }
                else if(temp.attr('name') == 'confirm_password'){
                    if(input.value != $('[name="password"]').val()){
                        showError(input, temp, error, 'Password do not match');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password do not match');
                    }
                    else if(input.value.length < 6){
                        showError(input, temp, error, 'Password must be at least 6 characters');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password must be at least 6 characters');
                    }
                }

                !bool? clearError(input, temp, error) : '';
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                swal.close();
                !$('.is-invalid').is(':visible')? $('#registerForm').submit() : '';
            }, 2000)
        });

        async function showError(input, temp, error, message){
            await new Promise(resolve => setTimeout(resolve, 1000));

            bool = true;

            if(input.type != 'hidden'){
                temp.addClass('is-invalid');
            }
            else{
                temp.addClass('is-invalid');
                temp.next().addClass('is-invalid');
            }

            // DISPLAY ERROR MESSAGE
            error.text(message);
            error.parent().removeClass('hidden');
        }

        function clearError(input, temp, error){
            if($(input).hasClass('is-invalid')){
                if(input.type != 'hidden'){
                    temp.removeClass('is-invalid');
                }
                else{
                    temp.removeClass('is-invalid');
                    temp.next().removeClass('is-invalid');
                }

                // REMOVE ERROR MESSAGE IF VISIBLE
                if(error.parent().is(':visible')){
                    error.parent().addClass('hidden');
                }
            }
        }

        // LOGIN
        $('.submit3').on('click', () => {
            swal({
                type: 'question',
                title: 'Confirmation',
                text: 'Are you sure?',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                focusConfirm: true,
            }).then((result) => {
                if(result.value){
                    $.ajax({
                        type: 'post',
                        url: '{{ 'login' }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: result.value.login,
                            password: result.value.password
                        },
                        success: response => {
                            swal("Logging in...");
                            swal.showLoading();
                            setTimeout(() => {
                                window.location.href = "{{ route('dashboard') }}";
                            }, 2000);
                        },
                        error: response => {
                            swal("Logging in...");
                            swal.showLoading();
                            setTimeout(() => {
                                swal({
                                    type: 'error',
                                    title: 'Invalid Username or Password',
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                            }, 2000);
                        }
                    });
                }
            });
        });

        // MAPS
        var directionsService;
        var directionsRenderer;
        let distance;

        function mapInit(){
            setTimeout(() => {
                navigator.geolocation.getCurrentPosition(position => {
                    initMap(position.coords.latitude, position.coords.longitude)
                });
                console.log('init');
            }, 5000);
        }

        function initMap(lat, lng){
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            distance = new google.maps.DistanceMatrixService();

            var map = new google.maps.Map(document.getElementById("map"), {
                center: {lat: lat, lng: lng},
                zoom: 12,
            });
            directionsRenderer.setMap(map);

            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
                map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            let markers = [];

              // Listen for the event fired when the user selects a prediction and retrieve
              // more details for that place.
              searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                  return;
                }

                // Clear out the old markers.
                markers.forEach((marker) => {
                  marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();

                places.forEach((place) => {
                  if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                  }

                  $('#address').val(place.name);

                  // Create a marker for each place.
                    $('#lat').val(place.geometry.location.lat());
                    $('#lng').val(place.geometry.location.lng());

                  markers.push(
                    new google.maps.Marker({
                      map,
                      position: place.geometry.location,
                    })
                  );
                  if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                  } else {
                    bounds.extend(place.geometry.location);
                  }
                });
                map.fitBounds(bounds);
              });

            // CLLICK LISTENER
            map.addListener("click", (mapsMouseEvent) => {
                  $('#pac-input').val(mapsMouseEvent.latLng.lat() + ", " + mapsMouseEvent.latLng.lng());
                  $('#pac-input').focus();

                  let el = document.getElementById('pac-input');
                  var evt = new CustomEvent('keydown');
                  evt.which = 13;
                  evt.keyCode = 13;
                  el.dispatchEvent(evt);

                $('#lat').val(mapsMouseEvent.latLng.lat());
                $('#lng').val(mapsMouseEvent.latLng.lng());
            });
        }

        function calculate(){
            if($('#sid').val() == ""){
                swal({
                    type: 'error',
                    title: 'Must Choose Seller First',
                    timer: 800,
                    showConfirmButton: false
                })
            }
            else if($('#address').val() == ""){
                swal({
                    type: 'error',
                    title: 'Must Select Address First',
                    timer: 800,
                    showConfirmButton: false
                })
            }
            else{
                $.ajax({
                    url: '{{ route("getUserAddress") }}',
                    data: {id: $(sid).val()},
                    success: result => {
                        let origin = JSON.parse(result);

                        var request = {
                            origin: {lat: parseFloat(origin.lat), lng: parseFloat(origin.lng)},
                            destination: {lat: parseFloat($('#lat').val()), lng: parseFloat($('#lng').val())},
                            travelMode: 'DRIVING'
                        };

                        directionsService.route(request, function(result, status) {
                            if (status == 'OK') {

                                directionsRenderer.setOptions({
                                    strokeColor: "red"
                                }); 
                                directionsRenderer.setDirections(result);
                                console.log(result);
                            }
                        });

                        distance.getDistanceMatrix(
                          {
                            origins: [request.origin],
                            destinations: [request.destination],
                            travelMode: 'DRIVING',
                          }, callback);

                        function callback(response, status) {
                            console.log(response, status);
                        }
                    }
                })
            }
        }
    </script>