<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Checkout</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Checkout - Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .address-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .address-item {
            border: 2px solid #e5e5e5;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .address-item:hover {
            border-color: #ccc;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .address-item.selected {
            border-color: var(--primary-color, #000);
            background-color: #f9f9f9;
        }

        .address-item .form-check {
            margin: 0;
        }

        .address-item .form-check-input {
            margin-top: 0.25rem;
        }

        .address-item .form-check-label {
            cursor: pointer;
            width: 100%;
            padding-left: 0.5rem;
        }

        .address-details h6 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .alert-info {
            background-color: #e7f3ff;
            border-color: #b3d9ff;
            color: #004085;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        /* Select2 custom styling */
        .select2-container--default .select2-selection--single {
            height: 48px !important;
            border: 1px solid #e5e5e5 !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px !important;
            color: #333 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-dropdown {
            border: 1px solid #e5e5e5 !important;
            border-radius: 4px !important;
        }

        .select2-search__field {
            border: 1px solid #e5e5e5 !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
        }
    </style>
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')
        @include('website.pages.checkout.header')
        <section>
            <div class="container">
                <div class="row flex-column-reverse flex-xl-row">
                    @include('website.pages.checkout.form')
                    <div class="col-xl-1">
                        <div class="line-separation"></div>
                    </div>
                    @include('website.pages.checkout.products')
                </div>
            </div>
        </section>
        @include('website.main.footer')
    </div>
    @include('website.pages.home.cartModal')

    {{-- Add Address Modal --}}
    @if(Auth::guard('client')->check())
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAddressForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone*</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Label (e.g., Home, Work)*</label>
                                <input type="text" name="label" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City*</label>
                                <select name="city_id" class="form-select" required>
                                    <option value="">Choose City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zone*</label>
                                <select name="zone_id" class="form-select" required disabled>
                                    <option value="">Choose Zone</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">District*</label>
                                <select name="district_id" class="form-select" required disabled>
                                    <option value="">Choose District</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Street*</label>
                                <input type="text" name="street" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Building*</label>
                                <input type="text" name="building" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Floor*</label>
                                <input type="text" name="floor" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apartment*</label>
                                <input type="text" name="apartment" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="zip_code" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Full Address*</label>
                                <textarea name="full_address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_default" id="setDefault" value="1">
                                    <label class="form-check-label" for="setDefault">
                                        Set as default address
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveAddress()">Save Address</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Payment Receipt Upload Modal --}}
    <div class="modal fade" id="paymentReceiptModal" tabindex="-1" aria-labelledby="paymentReceiptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentReceiptModalLabel">Upload Payment Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="payment-instructions" class="mb-3"></p>
                    <form id="paymentReceiptForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="receipt_image" class="form-label">Upload Receipt/Screenshot*</label>
                            <input type="file" class="form-control" id="receipt_image" name="receipt_image" accept="image/*" required>
                            <small class="text-muted">Please upload a clear image of your payment receipt</small>
                        </div>
                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Transaction ID (Optional)</label>
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter transaction ID">
                        </div>
                        <input type="hidden" id="payment_method_id_hidden" name="payment_method_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitWithReceipt()">Continue to Order</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        @if(Auth::guard('client')->check())
        function saveAddress() {
            const form = document.getElementById('addAddressForm');
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Show loading state
            const saveBtn = event.target;
            saveBtn.disabled = true;
            saveBtn.textContent = 'Saving...';
            fetch('/client/addresses', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('addAddressModal')).hide();

                    // Show success message
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification('Address added successfully!', 'success');
                    }

                    // Reload page to show new address
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                        window.ShopFeatures.showNotification(data.message || 'Failed to add address', 'error');
                    }
                }
            })
            .catch(error => {
                // console.error('Error:', error);
                if (window.ShopFeatures && window.ShopFeatures.showNotification) {
                    window.ShopFeatures.showNotification('An error occurred. Please try again.', 'error');
                }
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.textContent = 'Save Address';
            });
        }
        @endif
    </script>

    @include('website.main.scripts')
    {{-- Select2 JS - Must be loaded after jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Initialize Select2 and Cascade Dropdowns after jQuery is loaded
        $(document).ready(function() {
            // console.log('🔧 Initializing Select2 and Cascade');
            // Initialize Select2 on all select elements
            $('#citySelect, #zoneSelect, #districtSelect').select2({
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: false,
                width: '100%'
            });

            @if(Auth::guard('client')->check())
            $('#addAddressForm select[name="city_id"], #addAddressForm select[name="zone_id"], #addAddressForm select[name="district_id"]').select2({
                dropdownParent: $('#addAddressModal'),
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: false,
                width: '100%'
            });
            @endif
            // Setup cascade for guest checkout form
            const citySelect = $('#citySelect');
            const zoneSelect = $('#zoneSelect');
            const districtSelect = $('#districtSelect');
            if (citySelect.length) {
                citySelect.on('change', function() {
                    const cityId = $(this).val();
                    // console.log('🏙️  City changed:', cityId);
                    // Reset and disable dependent selects
                    zoneSelect.empty().append('<option value="">Choose Zone*</option>').prop('disabled', true).trigger('change');
                    districtSelect.empty().append('<option value="">Choose District*</option>').prop('disabled', true).trigger('change');
                    if (cityId) {
                        // console.log('📡 Fetching zones for city:', cityId);
                        // Fetch zones for selected city
                        fetch(`/locations/zones/${cityId}`)
                            .then(response => {
                                // console.log('✅ Zones response:', response);
                                return response.json();
                            })
                            .then(zones => {
                                // console.log('✅ Zones data:', zones);
                                zones.forEach(zone => {
                                    zoneSelect.append(new Option(zone.zoneName, zone.id));
                                });
                                zoneSelect.prop('disabled', false);
                            })
                            .catch(error => console.error('❌ Error fetching zones:', error));
                    }
                });
                zoneSelect.on('change', function() {
                    const zoneId = $(this).val();
                    // console.log('🏘️  Zone changed:', zoneId);
                    // Reset and disable district select
                    districtSelect.empty().append('<option value="">Choose District*</option>').prop('disabled', true).trigger('change');
                    if (zoneId) {
                        // console.log('📡 Fetching districts for zone:', zoneId);
                        // Fetch districts for selected zone
                        fetch(`/locations/districts/${zoneId}`)
                            .then(response => {
                                // console.log('✅ Districts response:', response);
                                return response.json();
                            })
                            .then(districts => {
                                // console.log('✅ Districts data:', districts);
                                districts.forEach(district => {
                                    districtSelect.append(new Option(district.districtName, district.id));
                                });
                                districtSelect.prop('disabled', false);
                            })
                            .catch(error => console.error('❌ Error fetching districts:', error));
                    }
                });
            }
            // Setup cascade for modal form (logged in clients)
            @if(Auth::guard('client')->check())
            const modalCitySelect = $('#addAddressForm select[name="city_id"]');
            const modalZoneSelect = $('#addAddressForm select[name="zone_id"]');
            const modalDistrictSelect = $('#addAddressForm select[name="district_id"]');
            modalCitySelect.on('change', function() {
                const cityId = $(this).val();
                // console.log('🏙️  Modal City changed:', cityId);
                // Reset and disable dependent selects
                modalZoneSelect.empty().append('<option value="">Choose Zone</option>').prop('disabled', true).trigger('change');
                modalDistrictSelect.empty().append('<option value="">Choose District</option>').prop('disabled', true).trigger('change');
                if (cityId) {
                    // Fetch zones for selected city
                    fetch(`/locations/zones/${cityId}`)
                        .then(response => response.json())
                        .then(zones => {
                            zones.forEach(zone => {
                                modalZoneSelect.append(new Option(zone.zoneName, zone.id));
                            });
                            modalZoneSelect.prop('disabled', false);
                        })
                        .catch(error => console.error('Error fetching zones:', error));
                }
            });
            modalZoneSelect.on('change', function() {
                const zoneId = $(this).val();
                // console.log('🏘️  Modal Zone changed:', zoneId);
                // Reset and disable district select
                modalDistrictSelect.empty().append('<option value="">Choose District</option>').prop('disabled', true).trigger('change');
                if (zoneId) {
                    // Fetch districts for selected zone
                    fetch(`/locations/districts/${zoneId}`)
                        .then(response => response.json())
                        .then(districts => {
                            districts.forEach(district => {
                                modalDistrictSelect.append(new Option(district.districtName, district.id));
                            });
                            modalDistrictSelect.prop('disabled', false);
                        })
                        .catch(error => console.error('Error fetching districts:', error));
                }
            });
            @endif
            // console.log('✅ Select2 and Cascade initialized');
        });
    </script>

    {{-- Shipping Rate Functions --}}
    @include('website.pages.checkout.shipping-script')

    {{-- Form Submission Debugging --}}
    <script>
        $(document).ready(function() {
            $('#checkoutForm').on('submit', function(e) {
                // console.log('🚀 Form submitting...');
                // console.log('📦 Form Data:', $(this).serialize());
                // console.log('💳 Payment Method:', $('input[name="payment-method"]:checked').val());
                // console.log('🚚 Shipping Rate ID:', $('input[name="shipping_rate_id"]').val());
                // console.log('📍 Address ID:', $('input[name="address_id"]:checked').val());
                // Check if payment method is selected
                if (!$('input[name="payment-method"]:checked').val()) {
                    // console.error('❌ No payment method selected!');
                    alert('Please select a payment method');
                    e.preventDefault();
                    return false;
                }
                // Check if shipping rate is selected
                if (!$('input[name="shipping_rate_id"]').val()) {
                    // console.error('❌ No shipping rate selected!');
                    alert('Please select your city/address to calculate shipping');
                    e.preventDefault();
                    return false;
                }
                // Check if payment method requires receipt upload
                const selectedPaymentSlug = $('input[name="payment-method"]:checked').data('slug');
                const requiresReceipt = ['vodafone-cash', 'instapay', 'valu'].includes(selectedPaymentSlug);
                if (requiresReceipt) {
                    e.preventDefault();
                    // Set payment method instructions
                    let instructions = '';
                    if (selectedPaymentSlug === 'vodafone-cash') {
                        instructions = '<strong>Vodafone Cash Instructions:</strong><br>Please transfer the total amount to: <strong>01234567890</strong><br>Then upload your payment receipt below.';
                    } else if (selectedPaymentSlug === 'instapay') {
                        instructions = '<strong>InstaPay Instructions:</strong><br>Please transfer the total amount to: <strong>username@instapay</strong><br>Then upload your payment receipt below.';
                    } else if (selectedPaymentSlug === 'valu') {
                        instructions = '<strong>Valu Instructions:</strong><br>Please complete your Valu payment and upload the confirmation receipt.';
                    }
                    $('#payment-instructions').html(instructions);
                    $('#payment_method_id_hidden').val($('input[name="payment-method"]:checked').val());
                    $('#paymentReceiptModal').modal('show');
                    return false;
                }
                // console.log('✅ All validations passed, submitting...');
            });
        });

        // Submit form with receipt
        function submitWithReceipt() {
            const receiptFile = document.getElementById('receipt_image').files[0];
            if (!receiptFile) {
                alert('Please upload a payment receipt');
                return;
            }
            // console.log('📸 Receipt file:', receiptFile.name, receiptFile.size, 'bytes');
            // Create FormData and copy all form fields from checkoutForm
            const checkoutForm = document.getElementById('checkoutForm');
            const formData = new FormData();
            // Add all checkout form fields
            const formElements = checkoutForm.elements;
            for (let i = 0; i < formElements.length; i++) {
                const element = formElements[i];
                if (element.name && !element.disabled) {
                    if (element.type === 'radio' || element.type === 'checkbox') {
                        if (element.checked) {
                            formData.append(element.name, element.value);
                        }
                    } else if (element.type !== 'file') {
                        formData.append(element.name, element.value);
                    }
                }
            }
            // Add receipt file and transaction ID
            formData.append('receipt_image', receiptFile, receiptFile.name);
            formData.append('transaction_id', document.getElementById('transaction_id').value || '');
            // console.log('📦 Submitting with receipt...');
            // Submit via AJAX
            fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // console.log('✅ Response:', data);
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    // console.log(data);
                    alert(data.message || 'An error occurred while processing your order'+ data);
                    $('#paymentReceiptModal').modal('hide');
                }
            })
            .catch(error => {
                // console.error('❌ Error:', error);
                alert('An error occurred while processing your order');
                $('#paymentReceiptModal').modal('hide');
            });
        }
    </script>
</body>
</html>

