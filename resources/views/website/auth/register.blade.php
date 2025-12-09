<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Register</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Create a new account at Aura Beauty Care">
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
                        <h3 class="text-center heading">Register</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Register
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- register -->
        <section class="flat-spacing">
            <div class="container">
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
                            <h4>Register</h4>
                        </div>
                        <form action="{{ route('client.register.post') }}" method="POST" class="form-login form-has-password">
                            @csrf
                            <div class="wrap">
                                <fieldset class="">
                                    <input class="@error('first_name') is-invalid @enderror"
                                           type="text"
                                           placeholder="First Name *"
                                           name="first_name"
                                           tabindex="1"
                                           value="{{ old('first_name') }}"
                                           aria-required="true"
                                           required="">
                                    @error('first_name')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="">
                                    <input class="@error('last_name') is-invalid @enderror"
                                           type="text"
                                           placeholder="Last Name *"
                                           name="last_name"
                                           tabindex="2"
                                           value="{{ old('last_name') }}"
                                           aria-required="true"
                                           required="">
                                    @error('last_name')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="">
                                    <input class="@error('email') is-invalid @enderror"
                                           type="email"
                                           placeholder="Email address *"
                                           name="email"
                                           tabindex="3"
                                           value="{{ old('email') }}"
                                           aria-required="true"
                                           required="">
                                    @error('email')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="">
                                    <input class="@error('phone') is-invalid @enderror"
                                           type="tel"
                                           placeholder="Phone Number *"
                                           name="phone"
                                           tabindex="4"
                                           value="{{ old('phone') }}"
                                           aria-required="true"
                                           required="">
                                    @error('phone')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="">
                                    <select class="@error('gender') is-invalid @enderror"
                                            name="gender"
                                            tabindex="5"
                                            aria-required="true"
                                            required="">
                                        <option value="">Select Gender *</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="">
                                    <input class="@error('birthdate') is-invalid @enderror"
                                           type="date"
                                           placeholder="Birthdate *"
                                           name="birthdate"
                                           tabindex="6"
                                           value="{{ old('birthdate') }}"
                                           aria-required="true"
                                           required="">
                                    @error('birthdate')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <fieldset class="position-relative password-item">
                                    <input class="input-password @error('password') is-invalid @enderror"
                                           type="password"
                                           placeholder="Password *"
                                           name="password"
                                           tabindex="7"
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
                                <fieldset class="position-relative password-item">
                                    <input class="input-password @error('password_confirmation') is-invalid @enderror"
                                           type="password"
                                           placeholder="Confirm Password *"
                                           name="password_confirmation"
                                           tabindex="8"
                                           value=""
                                           aria-required="true"
                                           required="">
                                    <span class="toggle-password unshow">
                                        <i class="icon-eye-hide-line"></i>
                                    </span>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </fieldset>
                                <div class="d-flex align-items-center">
                                    <div class="tf-cart-checkbox">
                                        <div class="tf-checkbox-wrapp">
                                            <input class="@error('agree_terms') is-invalid @enderror"
                                                   type="checkbox"
                                                   id="login-form_agree"
                                                   name="agree_terms"
                                                   {{ old('agree_terms') ? 'checked' : '' }}>
                                            <div>
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <label class="text-secondary-2" for="login-form_agree">
                                            I agree to&nbsp;
                                        </label>
                                    </div>
                                    <a href="{{ route('home') }}" title="Terms of Service"> Terms of Service</a>
                                </div>
                                @error('agree_terms')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="button-submit">
                                <button class="tf-btn btn-fill" type="submit">
                                    <span class="text text-button">Register</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="right">
                        <h4 class="mb_8">Already have an account?</h4>
                        <p class="text-secondary">Welcome back. Sign in to access your personalized experience, saved preferences, and more. We're thrilled to have you with us again!</p>
                        <a href="{{ route('client.login') }}" class="tf-btn btn-fill"><span class="text text-button">Login</span></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /register -->

        @include('website.main.footer')
    </div>

    @include('website.main.scripts')
</body>
</html>
