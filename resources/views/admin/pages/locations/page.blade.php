<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm me-2" type="button" data-bs-toggle="modal" data-bs-target="#createLocationModal">
            <i data-lucide="plus" class="fs-sm me-1"></i>Add New Location
        </span>
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#importJsonModal">
            <i data-lucide="upload" class="fs-sm me-1"></i>Import JSON
        </span>
        <h3 class="fw-bold">
            Locations Management
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
                                <input type="text" id="searchCities" class="form-control" placeholder="Search cities by name, code, or ID...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>City Name</th>
                                <th>Code</th>
                                <th>Zones</th>
                                <th>Districts</th>
                                <th>Addresses</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="citiesTableBody">
                            @forelse($cities as $city)
                                <tr>
                                    <td>{{ $city->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.locations.show', $city->id) }}" class="text-primary fw-bold">
                                            {{ $city->cityName }}
                                        </a>
                                        @if($city->cityOtherName)
                                            <br><small class="text-muted">{{ $city->cityOtherName }}</small>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info">{{ $city->cityCode }}</span></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $city->zones_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $city->districts_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $city->addresses_count }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light me-1" onclick="editCity({{ $city->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCity({{ $city->id }}, '{{ $city->cityName }}')" title="Delete">
                                            <i data-lucide="trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-center">
                                        <i data-lucide="map-pin" style="width: 48px; height: 48px; color: #ccc;"></i>
                                        <p class="mt-2 text-muted">No locations found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($cities->hasPages())
                    <div class="mt-3">
                        {{ $cities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter cities table
    document.getElementById('searchCities').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('citiesTableBody');
        const rows = tableBody.getElementsByTagName('tr');
        
        Array.from(rows).forEach(row => {
            const cityName = row.cells[1]?.textContent.toLowerCase() || '';
            const cityCode = row.cells[2]?.textContent.toLowerCase() || '';
            const cityId = row.cells[0]?.textContent.toLowerCase() || '';
            
            if (cityName.includes(searchTerm) || cityCode.includes(searchTerm) || cityId.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
