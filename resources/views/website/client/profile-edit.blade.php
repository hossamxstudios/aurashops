<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - My Account</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="My Account - Aura Beauty Care">
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
            <div class="pt-5 container-full">
                <div class="pt-5 row">
                    <div class="col-12">
                        <h3 class="text-center heading">My Account</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                My Account
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <div class="btn-sidebar-account">
            <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount"><i class="icon icon-squares-four"></i></button>
        </div>

        <!-- my-account -->
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

                <div class="my-account-wrap">
                    @include('website.client.partials.sidebar')

                    <div class="my-account-content">
                        <div class="account-details">
                            <form action="{{ route('client.profile.update') }}" method="POST" class="form-account-details form-has-password">
                                @csrf
                                @method('PATCH')

                                <div class="account-info">
                                    <h5 class="title">Information</h5>
                                    <div class="cols mb_20">
                                        <fieldset class="">
                                            <input class="@error('first_name') is-invalid @enderror"
                                                   type="text"
                                                   placeholder="First Name*"
                                                   name="first_name"
                                                   value="{{ old('first_name', $client->first_name) }}"
                                                   aria-required="true"
                                                   required="">
                                            @error('first_name')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="">
                                            <input class="@error('last_name') is-invalid @enderror"
                                                   type="text"
                                                   placeholder="Last Name*"
                                                   name="last_name"
                                                   value="{{ old('last_name', $client->last_name) }}"
                                                   aria-required="true"
                                                   required="">
                                            @error('last_name')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                    </div>
                                    <div class="cols mb_20">
                                        <fieldset class="">
                                            <input class="@error('email') is-invalid @enderror"
                                                   type="email"
                                                   placeholder="Email address*"
                                                   name="email"
                                                   value="{{ old('email', $client->email) }}"
                                                   aria-required="true"
                                                   required="">
                                            @error('email')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="">
                                            <input class="@error('phone') is-invalid @enderror"
                                                   type="tel"
                                                   placeholder="Phone*"
                                                   name="phone"
                                                   value="{{ old('phone', $client->phone) }}"
                                                   aria-required="true"
                                                   required="">
                                            @error('phone')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                    </div>
                                    <div class="cols mb_20">
                                        <fieldset class="">
                                            <select class="@error('gender') is-invalid @enderror"
                                                    name="gender"
                                                    aria-required="true"
                                                    required="">
                                                <option value="">Select Gender *</option>
                                                <option value="male" {{ old('gender', $client->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $client->gender) == 'female' ? 'selected' : '' }}>Female</option>
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
                                                   value="{{ old('birthdate', $client->birthdate ? $client->birthdate->format('Y-m-d') : '') }}"
                                                   aria-required="true"
                                                   required="">
                                            @error('birthdate')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="account-password">
                                    <h5 class="title">Change Password (Optional)</h5>
                                    <p class="mb-3 text-secondary">Leave blank if you don't want to change your password</p>
                                    <fieldset class="position-relative password-item mb_20">
                                        <input class="input-password @error('current_password') is-invalid @enderror"
                                               type="password"
                                               placeholder="Current Password"
                                               name="current_password"
                                               value="">
                                        <span class="toggle-password unshow">
                                            <i class="icon-eye-hide-line"></i>
                                        </span>
                                        @error('current_password')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </fieldset>
                                    <fieldset class="position-relative password-item mb_20">
                                        <input class="input-password @error('password') is-invalid @enderror"
                                               type="password"
                                               placeholder="New Password"
                                               name="password"
                                               value="">
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
                                               placeholder="Confirm Password"
                                               name="password_confirmation"
                                               value="">
                                        <span class="toggle-password unshow">
                                            <i class="icon-eye-hide-line"></i>
                                        </span>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </fieldset>
                                </div>

                                <div class="button-submit">
                                    <button class="tf-btn btn-fill" type="submit">
                                        <span class="text text-button">Update Account</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->

        <div class="offcanvas offcanvas-start canvas-sidebar" id="mbAccount">
            <div class="canvas-wrapper">
                <header class="canvas-header">
                    <span class="text-btn-uppercase">SIDEBAR ACCOUNT</span>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
                </header>
                <div class="canvas-body sidebar-mobile-append"></div>
            </div>
        </div>
        @include('website.main.footer')
    </div>
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')
</body>
</html>
