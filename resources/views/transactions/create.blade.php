@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    @include('booking.includes.toolbar')
                </div>

                <div class="box-body">
                    <form method="POST" action="{{ route('transactions.store') }}" id="createForm">
                        @csrf

                        <div class="row row1">
                            <div class="col-md-4">

                                <div class="row">
                                    <label for="schedule">Schedule <h6 style="color: red; display: inline-block; vertical-align:baseline;">(if not ASAP)</h6></label>
                                    <input type="text" class="form-control" name="schedule" id="schedule" placeholder="Select Schedule" readonly>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="scheduleError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="row">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control puwy" name="fname" placeholder="Enter First Name" autofocus>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="fnameError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="row">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control puwy" name="lname" placeholder="Enter Last Name">
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="lnameError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="row">
                                    <label for="contact">Contact Number</label>
                                    <input type="text" class="form-control puwy" name="contact" placeholder="Enter Contact Number">
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="contactError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="row">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control puwy" name="address" id="address" placeholder="Enter Address" readonly>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="addressError"></strong>
                                    </span>
                                </div>

                                <br>

                                <div class="row">
                                    <label for="comments">Comment</label>
                                    <textarea class="form-control" name="comments" id="comments" placeholder="Enter comments" cols="30" rows="5"></textarea>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="commentsError"></strong>
                                    </span>
                                </div>

                                <br>

                                <h3><b>Will be paid by:</b></h3>
                                <input type="radio" name="paid_by" value="Seller" checked> Seller<br>
                                <input type="radio" name="paid_by" value="Customer"> Customer<br>

                                <br>

                                <h3><b>Size:</b></h3>
                                <input type="radio" name="size" value="Small" checked> Small (12" to 19")<br>
                                <input type="radio" name="size" value="Medium"> Medium (15" to 22")<br>
                                <input type="radio" name="size" value="Large"> Large (21" to 25")<br>

                                <br>

                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                                <input type="hidden" name="price" id="price">
                                <input type="hidden" name="eta" id="eta">

                                <br>
                            </div>

                            <div class="col-md-8">
                                <br>
                                <input id="pac-input" class="control" type="text" placeholder="Search Box"/>
                                <div id="map" style="width: 100%; position: block;"></div>
                            </div>
                        </div>

                        <div class="row row2">
                            <div class="col-md-2">
                                <p style="margin-bottom: 3px;">ETA: </p>
                                <p style="margin-bottom: 3px;">Base Fare: </p>
                                <p style="margin-bottom: 3px;">Over Mileage(2km Base Distance): </p>
                                <p style="margin-bottom: 3px;">Total: </p>
                            </div>
                            <div class="col-md-2">
                                <p style="margin-bottom: 3px;"><span id="eta2">Select Location</span> </p>
                                <p style="margin-bottom: 3px;" id="bf">&#8369;{{ $price ?? "300.00" }}</p>
                                <p style="margin-bottom: 3px;">&#8369;<span id="overM">0.00</span> (Distance: <span id="distance">0.0</span> KM)</p>
                                <p style="margin-bottom: 3px;">&#8369;<span id="total">{{ $price ?? "300.00" }}</span></p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2  col-md-offset-10">
                                <a class="btn btn-primary submit">Proceed</a>
                                <a class="btn btn-danger" onclick="calculate()">Calculate</a>
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
@endpush

@push('before-scripts')
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWhOJBEOFENT7gJA-p_Zqwhkfmae8RR_o&libraries=places&callback=mapInit"></script>
    <script src="https://unpkg.com/paymaya-js-sdk@2.0.0/dist/bundle.js"></script>
@endpush

@push('after-scripts')

    <script>
        let bool;

        let picker = $('[name="schedule"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y H:i K',
            dateFormat: 'Y-m-d H:i:ss',
            enableTime: true,
            minuteIncrement: 15,
            minDate: moment().format('YYYY-MM-DD'),
            minTime: "14:00",
            onChange: (date, b, instance) => {
                let tempT = "";
                let tempD = "";

                if(moment(date[0]).format("YYYY-MM-DD") == moment().format("YYYY-MM-DD")){
                    tempT = moment().add("30", 'm').format("HH:mm");
                    tempD = moment().format("YYYY-MM-DD");
                }
                else{
                    tempT = moment(moment(date[0]).format("YYYY-MM-DD")).add("15", "m").format("HH:mm");
                    tempD = moment(moment(date[0])).format("YYYY-MM-DD");
                }

                picker.set("minTime", tempT);
            }
        });

        // VALIDATE ON SUBMIT
        $('.submit').click(() => {
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
                else if(temp.attr('name') == 'contact'){
                    if(!/^[0-9]*$/.test(input.value)){
                        showError(input, temp, error, 'Invalid Contact Number');
                    }
                }

                // setTimeout(() => {
                //     !bool? clearError(input, temp, error) : '';
                //     swal.close();
                // }, 1000);
                !bool? clearError(input, temp, error) : '';
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                swal.close();
                // !$('.is-invalid').is(':visible')? $('#createForm').submit() : '';
                !$('.is-invalid').is(':visible')? submit() : '';
            }, 1000)
        });

        function pay(price){
            console.log('paying');

            const object = {
              "totalAmount": {
                "value": price,
                "currency": "PHP",
              },
              "items": [
                {
                  "name": "Delivery",
                  "quantity": 1,
                  "amount": {
                    "value": price,
                    "details": {
                      "discount": 0,
                      "serviceCharge": 0,
                      "shippingFee": 0,
                      "tax": 0,
                      "subtotal": price
                    }
                  },
                  "totalAmount": {
                    "value": price,
                    "details": {
                      "subtotal": price
                    }
                  }
                }
              ],
              "redirectUrl": {
                "success": "http://127.0.0.1:8000/payment/success/{{ auth()->user()->id }}",
                "failure": "http://127.0.0.1:8000/payment/failure/{{ auth()->user()->id }}",
                "cancel": "http://127.0.0.1:8000/payment/cancel/{{ auth()->user()->id }}"
              },
              "requestReferenceNumber": moment().format("YYYYMMDDhhmmss"),
            };

            console.log(object);

            PayMayaSDK.init('pk-yaj6GVzYkce52R193RIWpuRR5tTZKqzBWsUeCkP9EAf', true);
            PayMayaSDK.createCheckout(object);
        }
        
        function submit(){
            let schedule = $('[name="schedule"]').val();
            let fname = $('[name="fname"]').val();
            let lname = $('[name="lname"]').val();
            let contact = $('[name="contact"]').val();
            let address = $('[name="address"]').val();
            let comments = $('[name="comments"]').val();
            let lat = $('[name="lat"]').val();
            let lng = $('[name="lng"]').val();
            let price = $('[name="price"]').val();
            let eta = $('[name="eta"]').val();
            let paid_by = $('[name="paid_by"]:checked').val();
            
            $.ajax({
                url: '{{ route('transactions.store') }}',
                type: 'POST',
                data: {
                    _token: $('[name="_token"]').val(),
                    schedule: schedule,
                    fname: fname,
                    lname: lname,
                    contact: contact,
                    address: address,
                    comments: comments,
                    lat: lat,
                    lng: lng,
                    price: price,
                    eta: eta,
                    paid_by: paid_by
                },
                success: result => {
                    swal({
                        type: 'success',
                        title: 'Successfully booked',
                        showConfirmButton: false,
                        timer: 1000,
                    }).then(() => {
                        if(paid_by == "Seller"){
                            swal({
                                title: 'Proceeding to payment',
                                showConfirmButton: false,
                                timer: 3000,
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            }).then(() => {
                                pay(price);
                            })
                        }
                        else{
                            window.location.href = "../transactions";
                        }
                    });
                }
            })
        }

        // function testPay(price){
        //     const myExampleObject = {
        //       "totalAmount": {
        //         "value": price,
        //         "currency": "PHP",
        //       },
        //       "items": [
        //         {
        //           "name": "Delivery",
        //           "quantity": 1,
        //           "amount": {
        //             "value": price,
        //             "details": {
        //               "discount": 0,
        //               "serviceCharge": 0,
        //               "shippingFee": 0,
        //               "tax": 0,
        //               "subtotal": price
        //             }
        //           },
        //           "totalAmount": {
        //             "value": 100,
        //             "details": {
        //               "subtotal": price
        //             }
        //           }
        //         }
        //       ],
        //     //   "logoUrl": "https://petx/favicon.ico",
        //     //   "iconUrl": "https://petx/favicon.ico",
            
        //       "redirectUrl": {
        //         "success": "https://www.petx.site/paymentSuccess",
        //       },
        //       "requestReferenceNumber": moment().format("YYYYMMDDhhmmss"),
        //     };

        //     PayMayaSDK.init('pk-Z0OSzLvIcOI2UIvDhdTGVVfRSSeiGStnceqwUE7n0Ah', true);
        //     PayMayaSDK.createCheckout(myExampleObject);
        // }

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
        var directionsService;
        var directionsRenderer;
        let distance;

        function mapInit(){
            navigator.geolocation.getCurrentPosition(position => {
                initMap(position.coords.latitude, position.coords.longitude)
            });
        }

        function initMap(lat, lng){
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            distance = new google.maps.DistanceMatrixService();

            var map = new google.maps.Map(document.getElementById("map"), {
                center: {lat: lat, lng: lng},
                zoom: 12,
            });

            $('#map').height($('.row1')[0].clientHeight);
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

                  if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                  } else {
                    bounds.extend(place.geometry.location);
                  }
                });
                map.fitBounds(bounds);

                setTimeout(() => {
                    calculate();
                }, 500);
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

                setTimeout(() => {
                    calculate();
                }, 500);
            });
        }

        function calculate(){
            let temp2 = $('[name="size"]:checked').val();
            let ctr = temp2 == "Small" ? 0 : temp2 == "Medium" ? 1 : 2;

            if($('#address').val() == ""){
                // swal({
                //     type: 'error',
                //     title: 'Must Select Address First',
                //     timer: 800,
                //     showConfirmButton: false
                // });

                $('#total').text(({{ $price ?? 300.00 }} + (ctr * 200)).toFixed(2));
                $('#price').val(({{ $price ?? 300.00 }} + (ctr * 200)).toFixed(2));
            }
            else{
                var request = {
                    origin: {lat: parseFloat({{ auth()->user()->lat }}), lng: parseFloat({{ auth()->user()->lng }})},
                    destination: {lat: parseFloat($('#lat').val()), lng: parseFloat($('#lng').val())},
                    travelMode: 'DRIVING'
                };

                directionsService.route(request, function(result, status) {
                    if (status == 'OK') {

                        directionsRenderer.setOptions({
                            strokeColor: "red"
                        }); 
                        directionsRenderer.setDirections(result);
                    }
                });

                distance.getDistanceMatrix(
                  {
                    origins: [request.origin],
                    destinations: [request.destination],
                    travelMode: 'DRIVING',
                  }, callback);

                function callback(response, status) {
                    let distance = (response.rows[0].elements[0].distance.value / 1000).toFixed(2);
                    let duration = response.rows[0].elements[0].duration.valu / 60;

                    let eta = response.rows[0].elements[0].duration.text;
                    let temp = distance <= 2 ? distance * 0 : (Math.ceil(distance - 2) * 40).toFixed(2);

                    $('#overM').text(temp);
                    $('#distance').text(distance);
                    $('#eta').val(eta);
                    $('#eta2').text(eta);
                    $('#total').text(({{ $price ?? 300.00 }} + (ctr * 200) + parseFloat(temp)).toFixed(2));
                    $('#price').val(({{ $price ?? 300.00 }} + (ctr * 200) + parseFloat(temp)).toFixed(2));
                }
            }
        }

        $('[name="size"]').on('change', () => {
            let temp = $('[name="size"]:checked').val();
            let ctr = temp == "Small" ? 0 : temp == "Medium" ? 1 : 2;
            $('#bf').html("₱" + ({{ $price ?? 300.00 }} + (ctr * 200)).toFixed(2));
            calculate();
        });
    </script>
@endpush