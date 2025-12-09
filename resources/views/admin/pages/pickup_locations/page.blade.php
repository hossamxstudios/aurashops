<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Pickup Location
        </span>
        <h3 class="fw-bold">
            Pickup Locations
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
                <!-- Search Filter -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                <input type="text" id="searchLocations" class="form-control" placeholder="Search by address or city...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Warehouse</th>
                                <th>Location</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="locationsTableBody">
                            @forelse($pickupLocations as $location)
                                <tr>
                                    <td>{{ $location->id }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($location->type) }}</span>
                                        @if($location->is_default)
                                            <br><span class="badge bg-warning mt-1">Default</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($location->warehouse)
                                            <span class="fw-bold">{{ $location->warehouse->name }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($location->city)
                                            <span>{{ $location->city->cityName }}</span>
                                        @endif
                                        @if($location->zone)
                                            <br><small class="text-muted">{{ $location->zone->zoneName }}</small>
                                        @endif
                                        @if($location->district)
                                            <br><small class="text-muted">{{ $location->district->districtName }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small">{{ Str::limit($location->full_address, 40) }}</span>
                                        @if($location->working_hours)
                                            <br><small class="text-muted"><i data-lucide="clock" class="icon-sm"></i> {{ $location->working_hours }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($location->contact_person_name)
                                            <span class="small">{{ $location->contact_person_name }}</span>
                                            @if($location->contact_person_phone)
                                                <br><small class="text-muted"><i data-lucide="phone" class="icon-sm"></i> {{ $location->contact_person_phone }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($location->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light" onclick="editLocation({{ $location->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteLocation({{ $location->id }}, '{{ addslashes($location->type) }}')" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No pickup locations found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $pickupLocations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.pickup_locations.createModal')
@include('admin.pages.pickup_locations.editModal')
@include('admin.pages.pickup_locations.deleteModal')

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter locations table
    document.getElementById('searchLocations').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('locationsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const address = row.cells[4]?.textContent.toLowerCase() || '';
            const location = row.cells[3]?.textContent.toLowerCase() || '';

            if (address.includes(searchTerm) || location.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
