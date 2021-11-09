@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('users.includes.toolbar')
				</div>

				<div class="box-body">
					<form method="POST" action="{{ route('users.update') }}" id="editForm">
                        @csrf

                        <input type="hidden" name="id" value="{{ $user->id }}">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control aeigh" name="fname" placeholder="Enter First Name" autofocus value="{{ $user->fname }}">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="fnameError"></strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control aeigh" name="mname" placeholder="Enter Middle Name" value="{{ $user->mname }}">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="mnameError"></strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control aeigh" name="lname" placeholder="Enter Last Name" value="{{ $user->lname }}">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="lnameError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control aeigh" name="address" placeholder="Enter Address" readonly value="{{ $user->address }}">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="addressError"></strong>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="lat" class="aeigh" value="{{ $user->lat }}">
                        <input type="hidden" name="lng" class="aeigh" value="{{ $user->lng }}">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control aeigh" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="emailError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control aeigh" name="contact" placeholder="Enter Contact Number" value="{{ $user->contact }}">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="contactError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="birthday">Birthday</label>
                                <input type="text" class="form-control aeigh" name="birthday" placeholder="Select Birthday">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="birthdayError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="gender">Gender</label>
                                <br>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Male" checked> Male
                                </label>
                                &nbsp; &nbsp;
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Female"> Female
                                </label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 col-md-offset-10">
                                <a class="btn btn-primary submit pull-right">Update</a>
                            </div>
                        </div>

                    </form>
				</div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

</section>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

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
@endpush

@push('before-scripts')
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&libraries=places" async></script>

    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD'),
            defaultDate: '{{ $user->birthday }}'
        });

        $('[name="gender"][value="{{ $user->gender }}"]').click();
    </script>
@endpush

@push('after-scripts')

    <script>
        let bool;

        // VALIDATE ON SUBMIT
        $('.submit').click(() => {
            let inputs = $('.aeigh:not(".input")');

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
                            rules: 'email|unique:users,email,{{ $user->id }}'
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
                
                !bool? clearError(input, temp, error) : '';
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                swal.close();
                !$('.is-invalid').is(':visible')? $('#editForm').submit() : '';
            }, 1000)
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
@endpush