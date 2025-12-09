<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createZoneModal">
            <i data-lucide="plus" class="fs-sm me-1"></i>Add New Zone
        </span>
        <h3 class="fw-bold">
            Zones Management
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
                                <th>Zone ID</th>
                                <th>City</th>
                                <th>Zone Name</th>
                                <th>Other Name</th>
                                <th>Pickup</th>
                                <th>Drop-off</th>
                                <th>Status</th>
                                <th>Districts</th>
                                <th>Addresses</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($zones as $zone)
                                <tr>
                                    <td>{{ $zone->id }}</td>
                                    <td><code>{{ $zone->zoneId }}</code></td>
                                    <td><span class="badge bg-primary">{{ $zone->city->cityName }}</span></td>
                                    <td><strong>{{ $zone->zoneName }}</strong></td>
                                    <td>{{ $zone->zoneOtherName ?: 'N/A' }}</td>
                                    <td>
                                        @if($zone->pickupAvailability)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($zone->dropOffAvailability)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($zone->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $zone->districts_count }} districts</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $zone->addresses_count }} addresses</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light me-1" onclick="editZone({{ $zone->id }}, {{ $zone->city_id }}, '{{ $zone->zoneId }}', '{{ $zone->zoneName }}', '{{ $zone->zoneOtherName }}', {{ $zone->pickupAvailability ? 'true' : 'false' }}, {{ $zone->dropOffAvailability ? 'true' : 'false' }}, {{ $zone->is_active ? 'true' : 'false' }})">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteZone({{ $zone->id }}, '{{ $zone->zoneName }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5">
                                        <i class="ti ti-map-pin" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mt-2">No zones found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($zones->hasPages())
                    <div class="mt-3">
                        {{ $zones->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
