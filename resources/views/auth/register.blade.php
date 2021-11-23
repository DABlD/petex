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
              width: 400px;
            }

            #pac-input:focus {
              border-color: #4d90fe;
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
    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="section-heading text-center white">
                <h2>Registration</h2>
                <div class="line"></div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="appointment-form">
                
    <form method="POST" action="{{ route('register') }}" id="registerForm" style="color: white;" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="form-group col-md-4">

                <input type="text" class="form-control puwy" name="fname" placeholder="Enter First Name" autofocus>
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="fnameError"></strong>
                </span>
            </div>
            <div class="form-group col-md-4">

                <input type="text" class="form-control puwy" name="mname" placeholder="Enter Middle Name">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="mnameError"></strong>
                </span>
            </div>
            <div class="form-group col-md-4">

                <input type="text" class="form-control puwy" name="lname" placeholder="Enter Last Name">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="lnameError"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-8">
                <input type="text" class="form-control puwy" name="address" placeholder="Enter Address" readonly>
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="addressError"></strong>
                </span>
            </div>
        </div>
        <input type="hidden" name="lat" class="puwy">
        <input type="hidden" name="lng" class="puwy">

        <div class="row">
            <div class="form-group col-md-6">
                <input type="email" class="form-control puwy" name="email" placeholder="Enter Email">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="emailError"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">

                <input type="text" class="form-control puwy" name="contact" placeholder="Enter Contact Number">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="contactError"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <input type="text" class="form-control puwy" name="birthday" placeholder="Select Birthday">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="birthdayError"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                {{-- <label for="gender">Gender</label> --}}
                {{-- <br> --}}
                <label class="radio-inline">
                    <input type="radio" name="gender" value="Male" checked> Male
                </label>
                &nbsp; &nbsp;
                <label class="radio-inline">
                    <input type="radio" name="gender" value="Female"> Female
                </label>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <input type="password" class="form-control puwy" name="password" placeholder="Enter Password">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="passwordError"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">

                <input type="password" class="form-control puwy" name="confirm_password" placeholder="Confirm Password">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="confirm_passwordError"></strong>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-7" style="padding-left: 15px;">

                <label for="files" style="color: yellow;">
                    Note: Please upload the following Photocopy: <br>
                    <b>SELLER</b> - Any Valid Government ID <br>
                    <b>RIDER</b> - Drivers License and Vehicle Registration <br>
                </label>

                <input type="file" class="puwy" name="files[]" placeholder="Upload Files" multiple accept="image/*"><br>
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="filesError"></strong>
                </span>
            </div>
        </div>

        <input type="hidden" name="role" id="role">

        <br><br>
        <div class="form-group row mb-0 justify-content-center">
            <div class="col-md-2 offset-md-5">
                    <a class="btn dento-btn booking-btn submit" data-id="Seller" style="background-color: #FFC107 !important; border-color: #FFC107 !important">Register as Seller</a>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn dento-btn booking-btn submit" data-id="Rider" style="background-color: #17A2B8 !important; border-color: #17A2B8 !important">Register as Rider</a>
            </div>
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
<script src="{{ asset('js/flatpickr.js') }}"></script>
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/swal.js') }}"></script>
<script src="{{ asset('js/homepage/dento.bundle.js') }}"></script>
<script src="{{ asset('js/homepage/active.js') }}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&libraries=places" async></script>

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&callback=initMap&v=weekly" async></script> --}}

    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });

        let bool;

        // VALIDATE ON SUBMIT
        $('.submit').click(e => {
            let role = $(e.target).data('id');
            $('#role').val(role);

            let inputs = $('.puwy:not(".input")');
            
            swal('Validating');
            swal.showLoading();

            $.each(inputs, (index, input) => {
                let temp = $(input);
                let error = $('#' + temp.attr('name').replace(/\[\]/g, '') + 'Error');
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
                            console.log(result);
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
                else if(temp.attr('name') == 'files[]'){
                    let errorMessage = "";
                    
                    if(role == "Seller"){
                        if($(input)[0].files.length > 1){
                            errorMessage = "You must upload only your valid government ID";
                        }
                    }
                    else{
                        if($(input)[0].files.length < 2){
                            errorMessage = "You must upload your drivers license and vehicle registration";
                        }
                        else if($(input)[0].files.length > 2){
                            errorMessage = "You must upload only your drivers license and vehicle registration";
                        }
                    }

                    if(errorMessage != ""){
                        showError(input, temp, error, errorMessage);
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
                    else if(input.value.length < 8){
                        showError(input, temp, error, 'Password must be at least 8 characters');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password must be at least 8 characters');
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
                    $(temp).removeClass('is-invalid');
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
                title: 'Login Form',
                html: ` <input type="text" id="login" class="swal2-input" placeholder="Username">
                        <input type="password" id="password" class="swal2-input" placeholder="Password">`,
                confirmButtonText: 'Sign in',
                showCancelButton: true,
                cancelButtonText: 'Register',
                cancelButtonColor: '#f76c6b',
                showCloseButton: true,
                focusConfirm: true,
                preConfirm: () => {
                    const login = $('#login').val();
                    const password = $('#password').val();

                    if (!login || !password) {
                        swal.showValidationError(`Please enter username and password`);
                    }
                    return { login: login, password: password }
                }
            }).then((result) => {
                console.log(result);
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
                else if(result.cancel = 'dismiss'){
                    window.location.href = "{{ route('register') }}";
                }
            });
        });

        // MAPS
        $('[name="address"]').on('click', () => {
        // function initMap(){
            swal({
                title: 'Select Address',
                html: `
                    Lat: <span id="lat2" data-id="0.0">0.0</span> | Long: <span id="lng2" data-id="0.0">0.0</span>
                    <br><br>

                    <input type="hidden" id="address2"></input>
                    <input id="pac-input" class="control" type="text" placeholder="Search Box"/>
                    <div id="map" style="width: 100%; height: 50vh;"></div>
                `,
                width: '50%',
                onOpen: () => {
                    navigator.geolocation.getCurrentPosition(position => {
                        initMap(position.coords.latitude, position.coords.longitude)
                    });

                    function initMap(lat, lng){
                        var map = new google.maps.Map(document.getElementById("map"), {
                            center: {lat: lat, lng: lng},
                            zoom: 12,
                        });

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

                              $('#address2').val(place.name);

                              // Create a marker for each place.
                                $('#lat2').val(place.geometry.location.lat());
                                $('#lng2').val(place.geometry.location.lng());

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

                            $('#lat2').html(mapsMouseEvent.latLng.lat());
                            $('#lng2').html(mapsMouseEvent.latLng.lng());
                        });
                    }

                },
            }).then(result => {
                if(result.value){                
                    $('[name="address"]').val($('#address2').val());
                    $('[name="lat"]').val($('#lat2').val());
                    $('[name="lng"]').val($('#lng2').val());
                }
            });
        });
    </script>