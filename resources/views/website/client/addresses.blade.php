<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - My Addresses</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="My Addresses - Aura Beauty Care">
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
                        <h3 class="text-center heading">My Addresses</h3>
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
                                Addresses
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

        <!-- addresses -->
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
                        <div class="account-addresses">
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 title">My Addresses</h5>
                                <a href="{{ route('client.addresses.add') }}" class="tf-btn btn-fill">
                                    <span class="text text-button">+ Add New Address</span>
                                </a>
                            </div>

                            @if($addresses->count() > 0)
                                <div class="row g-4">
                                    @foreach($addresses as $address)
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="mb-3 d-flex justify-content-between align-items-start">
                                                        <h6>{{ $address->label ?? 'Address' }}</h6>
                                                        @if($address->is_default)
                                                            <span class="badge bg-primary">Default</span>
                                                        @endif
                                                    </div>
                                                    <p class="mb-2"><strong>{{ $address->full_name }}</strong></p>
                                                    <p class="mb-2">{{ $address->address_line_1 }}</p>
                                                    @if($address->address_line_2)
                                                        <p class="mb-2">{{ $address->address_line_2 }}</p>
                                                    @endif
                                                    <p class="mb-2">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                                    <p class="mb-3">{{ $address->country }}</p>
                                                    <p class="mb-3"><strong>Phone:</strong> {{ $address->phone }}</p>

                                                    <div class="gap-2 d-flex">
                                                        <a href="{{ route('client.addresses.edit', ['id' => $address->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                        <form action="{{ route('client.addresses.delete') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $address->id }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-5 text-center">
                                    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                                        <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <h6>No Addresses Saved</h6>
                                    <p class="text-secondary">Add your first address to make checkout easier!</p>
                                    <a href="{{ route('client.addresses.add') }}" class="mt-3 tf-btn btn-fill">
                                        <span class="text text-button">Add Address</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /addresses -->
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
