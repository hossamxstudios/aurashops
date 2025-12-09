     <div class="col-xl-6">
         <div class="flat-spacing tf-page-checkout">
             {{-- Display Success/Error Messages --}}
             @if(session('success'))
                 <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Success!</strong> {{ session('success') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
             @endif
             @if(session('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong>Error!</strong> {{ session('error') }}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
             @endif
             @if($errors->any())
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong>Please fix the following errors:</strong>
                     <ul class="mt-2 mb-0">
                         @foreach($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
             @endif
             <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}">
            @csrf
             @if(Auth::guard('client')->check())
                 {{-- Logged in client --}}
                 @if($addresses->count() > 0)
                     {{-- Has saved addresses --}}
                     <div class="wrap">
                         <h5 class="title">Select Delivery Address</h5>
                         <div class="address-list">
                             @foreach($addresses as $address)
                                 <div class="address-item {{ $address->is_default ? 'selected' : '' }}" data-address-id="{{ $address->id }}" data-city-id="{{ $address->city_id }}">
                                     <div class="form-check">
                                         <input class="form-check-input" type="radio" name="address_id" id="address{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} required>
                                         <label class="form-check-label" for="address{{ $address->id }}">
                                             <div class="address-details">
                                                 <h6 class="mb-2">{{ $address->label }}</h6>
                                                 <p class="mb-1 text-secondary-2">{{ $address->formatted_address }}</p>
                                                 <p class="mb-0 text-secondary-2"><strong>Phone:</strong> {{ $address->phone }}</p>
                                             </div>
                                         </label>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                         <div class="mt-3">
                             <a href="#" class="text-btn-uppercase" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                 <i class="icon-plus"></i> Add New Address
                             </a>
                         </div>
                     </div>
                 @else
                     {{-- No saved addresses --}}
                     <div class="wrap">
                         <h5 class="title">Add Delivery Address</h5>
                         <div class="alert alert-info">
                             <p class="mb-0">You don't have any saved addresses. Please add one to continue.</p>
                         </div>
                         <a href="#" class="tf-btn btn-fill w-100 radius-4" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                             <span class="text text-btn-uppercase">Add Address</span>
                         </a>
                     </div>
                 @endif
             @else
                 {{-- Guest user --}}
             <div class="wrap">
                 <h5 class="title">Personal & Delivery Information</h5>
                 <div class="info-box">
                     <div class="mb-3">
                         <h6 class="mb-2">Personal Information</h6>
                     </div>
                     <div class="grid-2">
                         <input type="text" name="first_name" placeholder="First Name*" required>
                         <input type="text" name="last_name" placeholder="Last Name*" required>
                     </div>
                     <div class="grid-2">
                         <input type="email" name="email" placeholder="Email Address*" required>
                         <input type="tel" name="phone" placeholder="Phone Number*" required>
                     </div>

                     <div class="mt-4 mb-3">
                         <h6 class="mb-2">Delivery Address</h6>
                     </div>
                     <div class="grid-2">
                         <div class="tf-select">
                             <select class="text-title" name="city_id" id="citySelect" required>
                                 <option value="">Choose City*</option>
                                 @foreach($cities as $city)
                                     <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <div class="tf-select">
                             <select class="text-title" name="zone_id" id="zoneSelect" required disabled>
                                 <option value="">Choose Zone*</option>
                             </select>
                         </div>
                     </div>
                     <div class="tf-select">
                         <select class="text-title" name="district_id" id="districtSelect" required disabled>
                             <option value="">Choose District*</option>
                         </select>
                     </div>
                     <div class="grid-2">
                         <input type="text" name="street" placeholder="Street*" required>
                         <input type="text" name="building" placeholder="Building*" required>
                     </div>
                     <div class="grid-2">
                         <input type="text" name="floor" placeholder="Floor*" required>
                         <input type="text" name="apartment" placeholder="Apartment*" required>
                     </div>
                     <input type="text" name="label" placeholder="Address Label (e.g., Home, Work)*" required>
                     <input type="text" name="zip_code" placeholder="Postal Code (Optional)">
                     <textarea name="full_address" placeholder="Full Address Details*" rows="1" required></textarea>
                </div>
            </div>
            @endif
            <div class="wrap">
                <h5 class="title">Choose payment Option:</h5>
                <div class="form-payment">
                     <div class="payment-box" id="payment-box">
                        @foreach ($payment_methods as $payment_method)
                         <div class="payment-item">
                             <label for="{{ $payment_method->slug }}" class="payment-header collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $payment_method->slug }}-payment" aria-controls="{{ $payment_method->slug }}-payment">
                                 <input type="radio" name="payment-method" class="tf-check-rounded" id="{{ $payment_method->slug }}" value="{{ $payment_method->id }}" data-slug="{{ $payment_method->slug }}">
                                 @if($payment_method->getFirstMediaUrl('icon'))
                                     <img src="{{ $payment_method->getFirstMediaUrl('icon') }}" alt="{{ $payment_method->name }}" style="width: 80px; height: auto; object-fit: contain; margin-right: 10px;">
                                 @endif
                                 <span class="text-title">{{ $payment_method->name }}</span>
                             </label>
                         </div>
                        @endforeach
                    </div>
                    <button type="submit" class="tf-btn btn-fill w-100 radius-4 justify-content-center">
                        <span class="text text-btn-uppercase">Place Order</span>
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
