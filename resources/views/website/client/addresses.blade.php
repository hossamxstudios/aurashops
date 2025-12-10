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
            <div class="mt-5 container-full">
                <div class="pt-5 row">
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
                        <div class="account-address">
                            <div class="flex-wrap gap-10 mb_20 d-flex justify-content-between align-items-center">
                                <h5 class="fw-5">My Address</h5>
                                <a href="{{ route('client.addresses.add') }}" class="tf-btn btn-fill animate-hover-btn">
                                    <span>Add New</span>
                                </a>
                            </div>
                            @if($addresses->count() > 0)
                                <div class="row">
                                    @foreach($addresses as $address)
                                        <div class="p-3 tmt-5 col-xl-12 col-md-12 border-bottom">
                                            <div class="box-address">
                                                <div class="box-head d-flex justify-content-between">
                                                    <h6>
                                                        {{ $address->label ?? 'Delivery Address' }}
                                                        @if($address->is_default)
                                                            <span class="badge">Default</span>
                                                        @endif
                                                    </h6>
                                                    <div class="dropdown">
                                                        <button class="btn-menu dropdown-toggle" type="button"
                                                            id="dropdownMenuButton{{ $address->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="icon icon-more"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $address->id }}">
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('client.addresses.edit', ['id' => $address->id]) }}">
                                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <g opacity="0.8">
                                                                            <path d="M13.8333 5.83366L10.1667 2.16699M1.5 14.5003L3.83427 14.2296C4.13618 14.1953 4.28714 14.1782 4.42848 14.134C4.5541 14.0951 4.67434 14.0402 4.78666 13.9709C4.91357 13.8926 5.02479 13.7914 5.24722 13.569L14.25 4.56699C15.0784 3.73856 15.0784 2.39543 14.25 1.56699C13.4216 0.738558 12.0784 0.738558 11.25 1.56699L2.24802 10.569C2.02559 10.7914 1.91437 10.9026 1.83606 11.0295C1.76675 11.1419 1.71186 11.2621 1.67296 11.3877C1.62876 11.529 1.61165 11.68 1.57743 11.9819L1.5 14.5003Z" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        </g>
                                                                    </svg>
                                                                    <span>Edit</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('client.addresses.delete') }}"
                                                                      method="POST"
                                                                      onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="id" value="{{ $address->id }}">
                                                                    <button type="submit" class="dropdown-item">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M3.83301 5.5H12.1663M6.66634 8.16667V11.5M9.33301 8.16667V11.5M2.16634 5.5H13.833V13.1667C13.833 13.7855 13.833 14.0949 13.7073 14.3316C13.5965 14.5387 13.4217 14.7135 13.2146 14.8243C12.9779 14.95 12.6685 14.95 12.0497 14.95H3.94967C3.33087 14.95 3.02147 14.95 2.78475 14.8243C2.57765 14.7135 2.40286 14.5387 2.29204 14.3316C2.16634 14.0949 2.16634 13.7855 2.16634 13.1667V5.5ZM5.33301 5.5V2.83333C5.33301 2.28105 5.78072 1.83333 6.33301 1.83333H9.66634C10.2186 1.83333 10.6663 2.28105 10.6663 2.83333V5.5H5.33301Z" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                        </svg>
                                                                        <span>Delete</span>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="box-content">
                                                    <p>{{ $address->street }}, Building {{ $address->building }}</p>
                                                    <p>Floor {{ $address->floor }}, Apartment {{ $address->apartment }}</p>
                                                    <p>{{ $address->district->districtName ?? '' }}, {{ $address->district->zone->zoneName ?? '' }}</p>
                                                    <p>{{ $address->district->zone->city->cityName ?? '' }}
                                                        @if($address->zip_code)
                                                            - {{ $address->zip_code }}
                                                        @endif
                                                    </p>
                                                    @if($address->phone)
                                                        <p><strong>Phone:</strong> {{ $address->phone }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-5 text-center empty-state">
                                    <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3" style="opacity: 0.3;">
                                        <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <h5 class="mb_8">No Address Found</h5>
                                    <p class="text_black-2">You haven't added any delivery addresses yet</p>
                                    <a href="{{ route('client.addresses.add') }}" class="mt-3 tf-btn btn-fill animate-hover-btn">
                                        <span>Add Your First Address</span>
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
