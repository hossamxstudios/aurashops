<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Login</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Login to Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')

        <!-- page-title -->
        <div class="page-title" style="background-image: url({{ asset('website/images/section/page-title.jpg') }});">
            <div class="container-full">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center heading">Login</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Login
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- login -->
        <section class="flat-spacing">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="login-wrap">
                    <div class="left">
                        <div class="heading">
                            <h4>Login</h4>
                        </div>
                        <form action="{{ route('client.login.post') }}" method="POST" class="form-login form-has-password">
                            @csrf
                            <div class="wrap">
                                <fieldset class="">
                                    <input class="@error('email') is-invalid @enderror"
                                           type="email"
                                           placeholder="Email address *"
                                           name="email"
                                           tabindex="1"
                                           value="{{ old('email') }}"
                                           aria-required="true"
                                           required="">
                                    @error('email')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="position-relative password-item">
                                    <input class="input-password @error('password') is-invalid @enderror"
                                           type="password"
                                           placeholder="Password *"
                                           name="password"
                                           tabindex="2"
                                           value=""
                                           aria-required="true"
                                           required="">
                                    <span class="toggle-password unshow">
                                        <i class="icon-eye-hide-line"></i>
                                    </span>
                                    @error('password')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="tf-cart-checkbox">
                                        <div class="tf-checkbox-wrapp">
                                            <input checked class="" type="checkbox" id="login-form_agree"
                                                name="remember">
                                            <div>
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <label for="login-form_agree">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="{{ route('client.password.request') }}"
                                        class="font-2 text-button forget-password link">Forgot Your Password?</a>
                                </div>
                            </div>
                            <div class="button-submit">
                                <button class="tf-btn btn-fill" type="submit">
                                    <span class="text text-button">Login</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        <h4 class="mb_8">New Customer</h4>
                        <p class="text-secondary">Be part of our growing family of new customers! Join us today and unlock a world of exclusive benefits, offers, and personalized experiences.</p>
                        <a href="{{ route('client.register') }}" class="tf-btn btn-fill"><span
                                class="text text-button">Register</span></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /login -->

        @include('website.main.footer')
    </div>

    @include('website.main.scripts')
</body>
</html>
