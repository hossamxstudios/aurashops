<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createDistrictModal">
            <i data-lucide="plus" class="fs-sm me-1"></i>Add New District
        </span>
        <h3 class="fw-bold">
            Districts Management
        </h3>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>District ID</th>
                                <th>City</th>
                                <th>Zone</th>
                                <th>District Name</th>
                                <th>Other Name</th>
                                <th>Pickup</th>
                                <th>Drop-off</th>
                                <th>Status</th>
                                <th>Addresses</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($districts as $district)
                                <tr>
                                    <td>{{ $district->id }}</td>
                                    <td><code>{{ $district->districtId }}</code></td>
                                    <td><span class="badge bg-primary">{{ $district->zone->city->cityName }}</span></td>
                                    <td><span class="badge bg-info">{{ $district->zone->zoneName }}</span></td>
                                    <td><strong>{{ $district->districtName }}</strong></td>
                                    <td>{{ $district->districtOtherName ?: 'N/A' }}</td>
                                    <td>
                                        @if($district->pickupAvailability)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($district->dropOffAvailability)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($district->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $district->addresses_count }} addresses</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light me-1" onclick="editDistrict({{ $district->id }}, {{ $district->zone->city_id }}, {{ $district->zone_id }}, '{{ $district->districtId }}', '{{ $district->districtName }}', '{{ $district->districtOtherName }}', {{ $district->pickupAvailability ? 'true' : 'false' }}, {{ $district->dropOffAvailability ? 'true' : 'false' }}, {{ $district->is_active ? 'true' : 'false' }})">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteDistrict({{ $district->id }}, '{{ $district->districtName }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5">
                                        <i class="ti ti-map-2" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mt-2">No districts found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($districts->hasPages())
                    <div class="mt-3">
                        {{ $districts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
