<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="ti ti-map-pin me-2"></i>Addresses</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#addAddressOffCanvas">
            <i class="ti ti-plus me-1"></i>Add Address
        </button>
    </div>
    <div class="card-body">
        @if($client->addresses->count() > 0)
            <div class="row g-3">
                @foreach($client->addresses as $address)
                    <div class="col-md-6">
                        <div class="card border {{ $address->is_default ? 'border-primary' : '' }} h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">
                                            {{ $address->label }}
                                            @if($address->is_default)
                                                <span class="badge bg-primary-subtle text-primary fs-xs ms-1">Default</span>
                                            @endif
                                        </h6>
                                        <p class="text-muted fs-xs mb-0">
                                            <i class="ti ti-phone fs-sm me-1"></i>{{ $address->phone }}
                                        </p>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-icon btn-ghost-light text-muted btn-sm" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if(!$address->is_default)
                                                <li>
                                                    <form action="{{ route('admin.addresses.setDefault', $address->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="ti ti-star me-2 fs-sm"></i>Set as Default
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="editAddress({{ $address->id }})">
                                                    <i class="ti ti-edit me-2 fs-sm"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteAddress({{ $address->id }}, '{{ $address->label }}')">
                                                    <i class="ti ti-trash me-2 fs-sm"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <p class="text-muted fs-sm mb-1">
                                        <i class="ti ti-building me-1"></i>
                                        {{ $address->full_address }}
                                    </p>
                                </div>

                                <div class="row g-2 mt-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Apartment</small>
                                        <span class="fs-sm">{{ $address->apartment ?: 'N/A' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Floor</small>
                                        <span class="fs-sm">{{ $address->floor ?: 'N/A' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Building</small>
                                        <span class="fs-sm">{{ $address->building }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Street</small>
                                        <span class="fs-sm">{{ $address->street }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">City</small>
                                        <span class="fs-sm">{{ $address->city->cityName ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Zone</small>
                                        <span class="fs-sm">{{ $address->zone->zoneName ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">District</small>
                                        <span class="fs-sm">{{ $address->district->districtName ?? 'N/A' }}</span>
                                    </div>
                                    @if($address->zip_code)
                                        <div class="col-12">
                                            <small class="text-muted d-block">Zip Code</small>
                                            <span class="fs-sm">{{ $address->zip_code }}</span>
                                        </div>
                                    @endif
                                    @if($address->lat && $address->lng)
                                        <div class="col-12 mt-2">
                                            <a href="https://www.google.com/maps?q={{ $address->lat }},{{ $address->lng }}" target="_blank" class="btn btn-light btn-sm w-100">
                                                <i class="ti ti-map-pin me-1"></i>View on Map
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="ti ti-map-pin text-muted" style="font-size: 3rem; opacity: 0.2;"></i>
                <h6 class="text-muted mt-3">No addresses yet</h6>
                <p class="text-muted fs-sm">Add the first address for this client</p>
            </div>
        @endif
    </div>
</div>
