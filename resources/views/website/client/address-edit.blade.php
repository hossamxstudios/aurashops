<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Edit Address</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Edit Address - Aura Beauty Care">
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
                        <h3 class="text-center heading">Edit Address</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                <a class="link" href="{{ route('client.dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                <a class="link" href="{{ route('client.addresses') }}">Addresses</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Edit
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

        <!-- edit-address -->
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

                <div class="my-account-wrap">
                    @include('website.client.partials.sidebar')

                    <div class="my-account-content">
                        <div class="account-address-form">
                            <h5 class="mb-4 title">Edit Address</h5>

                            <form action="#" method="POST" class="form-address">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <input type="text" name="label" placeholder="Address Label (e.g., Home, Work)" value="{{ old('label', $address->label) }}">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <input type="text" name="full_name" placeholder="Full Name*" value="{{ old('full_name', $address->full_name) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <input type="tel" name="phone" placeholder="Phone*" value="{{ old('phone', $address->phone) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset>
                                            <input type="text" name="address_line_1" placeholder="Address Line 1*" value="{{ old('address_line_1', $address->address_line_1) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset>
                                            <input type="text" name="address_line_2" placeholder="Address Line 2 (Optional)" value="{{ old('address_line_2', $address->address_line_2) }}">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <input type="text" name="city" placeholder="City*" value="{{ old('city', $address->city) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <input type="text" name="state" placeholder="State/Province*" value="{{ old('state', $address->state) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <input type="text" name="postal_code" placeholder="Postal Code*" value="{{ old('postal_code', $address->postal_code) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <input type="text" name="country" placeholder="Country*" value="{{ old('country', $address->country) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tf-cart-checkbox">
                                            <div class="tf-checkbox-wrapp">
                                                <input type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                                                <div>
                                                    <i class="icon-check"></i>
                                                </div>
                                            </div>
                                            <label for="is_default">Set as default address</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="gap-3 mt-4 button-submit d-flex">
                                    <button class="tf-btn btn-fill" type="submit">
                                        <span class="text text-button">Update Address</span>
                                    </button>
                                    <a href="{{ route('client.addresses') }}" class="tf-btn btn-outline">
                                        <span class="text text-button">Cancel</span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /edit-address -->
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
