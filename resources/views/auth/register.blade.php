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
                
    <form method="POST" action="{{ route('register') }}" id="registerForm" style="color: white;">
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
                <input type="text" class="form-control puwy" name="address" placeholder="Enter Address">
                <span class="invalid-feedback hidden" role="alert">
                    <strong id="addressError"></strong>
                </span>
            </div>
        </div>

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
    </script>