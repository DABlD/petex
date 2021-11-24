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
                                        <li><a class="navnav" data-href="home" href="#">Home</a></li>
                                        <li><a class="navnav" data-href="team" href="#">Our Team</a></li>
                                        <li><a class="navnav" data-href="contact" href="#">Contact Us</a></li>
                                        <li>
                                            @auth
                                                <a href="{{ route('dashboard') }}" class="btn dento-btn booking-btn">Dashboard</a>
                                            @endauth

                                            @guest
                                                <a href="#" class="btn dento-btn booking-btn">Sign In</a>
                                            @endguest
                                        </li>
                                    </ul>
                                </div>
                            </div>
        </nav>
    </div>
</div>
</div>
</header>

<section class="welcome-area" id="home">
<div class="welcome-slides owl-carousel">
<div class="welcome-welcome-slide bg-img bg-gradient-overlay jarallax" style="background-image:url(images/bg.jpg)">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="welcome-text text-center">
                    <h2 data-animation="fadeInUp" data-delay="100ms">Modes of Payment</h2>
                    <p data-animation="fadeInUp" data-delay="300ms">The PetEx offers E-Payment as mode of payment.</p>
                    <div class="welcome-btn-group">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="welcome-welcome-slide bg-img bg-gradient-overlay jarallax" style="background-image:url(images/bg2.jpg)">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="welcome-text text-center">
                    <h2 data-animation="fadeInDown" data-delay="100ms">Standard Rate</h2>
                    <p data-animation="fadeInDown" data-delay="300ms">Standard starting rate is applied on all areas within Metro Manila</p>
                    <div class="welcome-btn-group">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="welcome-welcome-slide bg-img bg-gradient-overlay jarallax" style="background-image:url(images/bg3.jpg)">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="welcome-text text-center">
                    <h2 data-animation="fadeInDown" data-delay="100ms">Metro Manila</h2>
                    <p data-animation="fadeInDown" data-delay="300ms">The PetEx only offers services in transporting your lovely pets within metro manila areas only.</p>
                    <div class="welcome-btn-group">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<!-- TEAM -->
<section class="dentist-area section-padding-100-0" id="team">
<div class="container">
<div class="row">
    <div class="col-12">
        <div class="section-heading text-center">
            <h2>Our Team</h2>
            <div class="line"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="single-dentist-area mb-100">
            <img src="images/em1.png" alt="">
            <div class="dentist-content">
                <div class="dentist-info bg-gradient-overlay">
                    <h5>Edric Peralejo</h5>
                    <p>Project Manager</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="single-dentist-area mb-100">
            <img src="images/em2.png" alt="">
            <div class="dentist-content">
                <div class="dentist-info bg-gradient-overlay">
                    <h5>Xeline Cabasag</h5>
                    <p>Database Manager</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="single-dentist-area mb-100">
            <img src="images/em3.png" alt="">
            <div class="dentist-content">
                <div class="dentist-info bg-gradient-overlay">
                    <h5>Paul Agana</h5>
                    <p>Designer</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="single-dentist-area mb-100">
            <img src="images/em4.png" alt="">
            <div class="dentist-content">
                <div class="dentist-info bg-gradient-overlay">
                    <h5>JK Yogyog</h5>
                    <p>Programmer</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<!-- CONTACT -->
<section class="book-an-oppointment-area section-padding-100 bg-img bg-gradient-overlay jarallax clearfix" style="background-image:url(images/contact-us-background.jpg); padding-bottom: 0px; background-size: cover;" id="contact">
    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="section-heading text-center white">
                <h2>Contact Us</h2>
                <div class="line"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="appointment-form">
                <form action="#" method="post">
                    <div class="row">


                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group mb-30">
                                <input type="text" name="fname" class="form-control" placeholder="First Name" required style="color: white;">
                            </div>
                        </div>
                        <div class="col-md-3"></div>

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group mb-30">
                                <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="col-md-3"></div>

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group mb-30">
                                <textarea name="message" class="form-control" placeholder="Your Message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-3"></div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn dento-btn">Send</button>
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

<script src="js/jquery.min.js"></script>
<script src="js/homepage/dento.bundle.js"></script>
<script src="js/homepage/active.js"></script>
<script src="js/swal.js"></script>

<script>
        @if ($errors->any())    
            swal({
                type: 'error',
                text: `
                    @foreach ($errors->all() as $error)
                        {{ $error }} "<br>;
                    @endforeach
                `
            });
        @endif

        @if(Session::has('success'))
            swal({
                type: 'success',
                title: '{{ Session::get('success') }}',
                // text: 'Wait for your account to be confirmed'
            });

            {{Session::forget('success')}};
        @endif

    $(".navnav").on("click", e => {
        $('html, body').animate({
            scrollTop: $("#" + $(e.target).data('href')).offset().top
        }, 1000);
    })

    $('.booking-btn').on('click', () => {
        swal({
            title: 'Login Form',
            html: ` <input type="text" id="login" class="swal2-input" placeholder="Email">
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
        }).then(result => {
            console.log(result);
            console.log(result.cancel);
            console.log(result.cancel == "dismiss");
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
            else if(result.dismiss == 'cancel'){
                window.location.href = "{{ route('register') }}";
            }
        });
    });
</script>

</body>
</html>