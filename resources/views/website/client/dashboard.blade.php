<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Dashboard</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Dashboard - Aura Beauty Care">
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
                        <h3 class="text-center heading">Dashboard</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Dashboard
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

        <!-- dashboard -->
        <section class="flat-spacing">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="my-account-wrap">
                    @include('website.client.partials.sidebar')

                    <div class="my-account-content">
                        <div class="account-dashboard">
                            <h5 class="mb-4 title">Welcome, {{ $client->full_name }}!</h5>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="text-center card-body">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                                                <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <h6>Total Orders</h6>
                                            <h3 class="mb-0">{{ $client->orders->count() }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="text-center card-body">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                                                <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <h6>Saved Addresses</h6>
                                            <h3 class="mb-0">{{ $client->addresses->count() }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="text-center card-body">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                                                <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <h6>Account Status</h6>
                                            <h3 class="mb-0 text-success">Active</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <h6 class="mb-3">Quick Actions</h6>
                                <div class="flex-wrap gap-3 d-flex">
                                    <a href="{{ route('client.orders') }}" class="tf-btn btn-fill">
                                        <span class="text text-button">View Orders</span>
                                    </a>
                                    <a href="{{ route('client.addresses') }}" class="tf-btn btn-outline">
                                        <span class="text text-button">Manage Addresses</span>
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="tf-btn btn-outline">
                                        <span class="text text-button">Edit Profile</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /dashboard -->

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
