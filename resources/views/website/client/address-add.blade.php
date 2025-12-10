<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Add Address</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Add Address - Aura Beauty Care">
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
                        <h3 class="text-center heading">Add New Address</h3>
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
                                Add
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

        <!-- add-address -->
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
                            <h5 class="mb-4 title">Add New Address</h5>

                            <form id="addAddressForm" method="POST" class="form-address">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <label class="form-label">Address Label*</label>
                                            <input type="text" name="label" placeholder="e.g., Home, Work"
                                                   value="{{ old('label') }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <label class="form-label">Phone*</label>
                                            <input type="tel" name="phone" placeholder="Phone Number"
                                                   value="{{ old('phone', $client->phone) }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-4">
                                        <fieldset>
                                            <label class="form-label">City*</label>
                                            <select name="city_id" class="form-select" required>
                                                <option value="">Choose City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                        {{ $city->cityName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-4">
                                        <fieldset>
                                            <label class="form-label">Zone*</label>
                                            <select name="zone_id" class="form-select" required disabled>
                                                <option value="">Choose City First</option>
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-4">
                                        <fieldset>
                                            <label class="form-label">District*</label>
                                            <select name="district_id" class="form-select" required disabled>
                                                <option value="">Choose Zone First</option>
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <label class="form-label">Street*</label>
                                            <input type="text" name="street" placeholder="Street Name"
                                                   value="{{ old('street') }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <label class="form-label">Building*</label>
                                            <input type="text" name="building" placeholder="Building Number"
                                                   value="{{ old('building') }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <label class="form-label">Floor*</label>
                                            <input type="text" name="floor" placeholder="Floor Number"
                                                   value="{{ old('floor') }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <label class="form-label">Apartment*</label>
                                            <input type="text" name="apartment" placeholder="Apartment Number"
                                                   value="{{ old('apartment') }}" required>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <fieldset>
                                            <label class="form-label">Zip Code (Optional)</label>
                                            <input type="text" name="zip_code" placeholder="Zip/Postal Code"
                                                   value="{{ old('zip_code') }}">
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tf-cart-checkbox">
                                            <div class="tf-checkbox-wrapp">
                                                <input type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
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
                                        <span class="text text-button">Save Address</span>
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
        <!-- /add-address -->
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

    <script>
        $(document).ready(function() {
            // ============================================
            // Cascade Dropdowns Structure:
            // City (المدينة) -> Zone (المنطقة) -> District (الحي)
            // ============================================

            const citySelect = $('select[name="city_id"]');
            const zoneSelect = $('select[name="zone_id"]');
            const districtSelect = $('select[name="district_id"]');

            console.log('📍 Add Address Page Loaded');

            // ============================================
            // Step 1: City -> Zones
            // ============================================
            citySelect.on('change', function() {
                const cityId = $(this).val();
                console.log('🏙️ City selected:', cityId);

                // Reset zone and district
                zoneSelect.html('<option value="">Loading Zones...</option>').prop('disabled', true);
                districtSelect.html('<option value="">Choose District</option>').prop('disabled', true);

                if (cityId) {
                    console.log('📡 Fetching zones for city:', cityId);
                    $.ajax({
                        url: '/locations/zones/' + cityId,
                        type: 'GET',
                        success: function(zones) {
                            console.log('✅ Loaded Zones:', zones.length);
                            zoneSelect.html('<option value="">Choose Zone</option>');

                            if (zones.length > 0) {
                                zones.forEach(function(zone) {
                                    zoneSelect.append(`<option value="${zone.id}">${zone.zoneName}</option>`);
                                });
                                zoneSelect.prop('disabled', false);
                            } else {
                                zoneSelect.html('<option value="">No Zones Available</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error('❌ Failed to load zones', xhr);
                            zoneSelect.html('<option value="">Error Loading Zones</option>');
                        }
                    });
                } else {
                    zoneSelect.html('<option value="">Choose City First</option>').prop('disabled', true);
                    districtSelect.html('<option value="">Choose Zone First</option>').prop('disabled', true);
                }
            });

            // ============================================
            // Step 2: Zone -> Districts
            // ============================================
            zoneSelect.on('change', function() {
                const zoneId = $(this).val();
                console.log('📍 Zone selected:', zoneId);

                // Reset district
                districtSelect.html('<option value="">Loading Districts...</option>').prop('disabled', true);

                if (zoneId) {
                    console.log('📡 Fetching districts for zone:', zoneId);
                    $.ajax({
                        url: '/locations/districts/' + zoneId,
                        type: 'GET',
                        success: function(districts) {
                            console.log('✅ Loaded Districts:', districts.length);
                            districtSelect.html('<option value="">Choose District</option>');

                            if (districts.length > 0) {
                                districts.forEach(function(district) {
                                    districtSelect.append(`<option value="${district.id}">${district.districtName}</option>`);
                                });
                                districtSelect.prop('disabled', false);
                            } else {
                                districtSelect.html('<option value="">No Districts Available</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error('❌ Failed to load districts', xhr);
                            districtSelect.html('<option value="">Error Loading Districts</option>');
                        }
                    });
                } else {
                    districtSelect.html('<option value="">Choose Zone First</option>').prop('disabled', true);
                }
            });

            // ============================================
            // Form Submission
            // ============================================
            $('#addAddressForm').on('submit', function(e) {
                e.preventDefault();

                // Enable all selects before serializing
                zoneSelect.prop('disabled', false);
                districtSelect.prop('disabled', false);

                const formData = $(this).serialize();
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.find('.text').text();

                console.log('📤 Submitting address:', formData);

                // Disable button and show loading
                submitBtn.prop('disabled', true).find('.text').text('Saving...');

                $.ajax({
                    url: '{{ route("client.addresses.store") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('✅ Success:', response);
                        if (response.success) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '{{ route("client.addresses") }}';
                                });
                            } else {
                                alert(response.message);
                                window.location.href = '{{ route("client.addresses") }}';
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('❌ Error:', xhr);

                        // Re-enable button
                        submitBtn.prop('disabled', false).find('.text').text(originalText);

                        // Re-disable selects if needed
                        if (!zoneSelect.val()) zoneSelect.prop('disabled', true);
                        if (!districtSelect.val()) districtSelect.prop('disabled', true);

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            Object.keys(errors).forEach(key => {
                                errorMsg += errors[key][0] + '\n';
                            });

                            console.error('Validation Errors:', errors);

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    text: errorMsg
                                });
                            } else {
                                alert('Validation Error:\n' + errorMsg);
                            }
                        } else {
                            let errorMessage = 'Something went wrong. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorMessage
                                });
                            } else {
                                alert('Error: ' + errorMessage);
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
