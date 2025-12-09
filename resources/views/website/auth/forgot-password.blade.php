<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Forgot Password</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Reset your password at Aura Beauty Care">
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
                        <h3 class="text-center heading">Forgot Password</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Forgot Password
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- forgot password -->
        <section class="flat-spacing">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
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

                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4 heading">
                                    <h4>Forgot Password</h4>
                                    <p class="text-secondary">Enter your email address and we'll send you a link to reset your password</p>
                                </div>
                                <form action="{{ route('client.password.email') }}" method="POST" class="form-login">
                                    @csrf
                                    <div class="wrap">
                                        <fieldset class="mb-3">
                                            <input class="@error('email') is-invalid @enderror"
                                                   type="email"
                                                   placeholder="Email address *"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   aria-required="true"
                                                   required="">
                                            @error('email')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                    </div>
                                    <div class="mb-3 button-submit">
                                        <button class="tf-btn btn-fill w-100" type="submit">
                                            <span class="text text-button">Send Reset Link</span>
                                        </button>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('client.login') }}" class="link">Back to Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /forgot password -->

        @include('website.main.footer')
    </div>

    @include('website.main.scripts')
</body>
</html>
