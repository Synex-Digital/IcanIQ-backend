<!DOCTYPE html>
<html lang="en" class="h-100">


<!-- Mirrored from sego.dexignzone.com/xhtml/page-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 19 Nov 2023 20:36:48 GMT -->

<head>
    <!-- Title -->
    <title>Sego - Restaurant Admin Dashboard Bootstrap HTML Template </title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="">

    <meta name="keywords"
        content="	admin dashboard, admin template, administration, analytics, bootstrap, cafe admin, elegant, food, health, kitchen, modern, responsive admin dashboard, restaurant dashboard, restaurant, chef, customer, breakfast, fastfood, nutrition,">
    <meta name="description"
        content="Experience the ultimate in restaurant management with Sego - the Restaurant Bootstrap Admin Dashboard. Streamline your restaurant operations, from reservations to menu updates, with this powerful and user-friendly admin tool. Elevate your dining experience today.">

    <meta property="og:title" content="Sego - Restaurant Admin Dashboard Bootstrap HTML Template">
    <meta property="og:description"
        content="Experience the ultimate in restaurant management with Sego - the Restaurant Bootstrap Admin Dashboard. Streamline your restaurant operations, from reservations to menu updates, with this powerful and user-friendly admin tool. Elevate your dining experience today.">
    <meta property="og:image" content="social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend') }}/images/favicon.png">
    <link href="{{ asset('backend') }}/css/style.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;family=Roboto:wght@100;300;400;500;700;900&amp;display=swap"
        rel="stylesheet">
</head>

<body class="h-100">
    <div class="authincation">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">

                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('backend/icaniq.png') }}" alt="" srcset="">
                                        {{-- <a href=""
                                            style="font-size: 2.5rem;
                                        font-weight: 700;color:#000000">iCAN-IQ</a> --}}
                                    </div>
                                    {{-- <h4 class="text-center mb-4">Your IP : {{ $ip }}</h4> --}}
                                    <form action="{{ route('login.admin') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="hello@example.com"
                                                name="email" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="position-relative">
                                                <input type="password" id="dz-password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    value="" name="password" placeholder="Entire Password"
                                                    required>
                                                <span class="show-pass eye">
                                                    <i class="fa fa-eye-slash"></i>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if (session('err'))
                                            <div class="form-group mb-3">
                                                <div class="alert alert-warning alert-dismissible fade show">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="btn-close">
                                                    </button>
                                                    <strong>Warning!</strong> {{ session('err') }}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                    @if ($admin == 0)
                                        <div class="new-account mt-3">
                                            <p class="">Create An Account <a class="text-primary"
                                                    href="{{ route('admin.register') }}">Sign Up</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
 Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('backend') }}/vendor/global/global.min.js"></script>
    <script src="{{ asset('backend') }}/js/custom.min.js"></script>
    <script src="{{ asset('backend') }}/js/deznav-init.js"></script>

</body>

<!-- Mirrored from sego.dexignzone.com/xhtml/page-register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 19 Nov 2023 20:36:48 GMT -->

</html>
