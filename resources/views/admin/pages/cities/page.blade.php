<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm me-2" type="button" data-bs-toggle="modal" data-bs-target="#createCityModal">
            <i data-lucide="plus" class="fs-sm me-1"></i>Add New City
        </span>
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#importJsonModal">
            <i data-lucide="upload" class="fs-sm me-1"></i>Import JSON
        </span>
        <h3 class="fw-bold">
            Cities Management
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
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>City ID</th>
                                <th>City Name</th>
                                <th>Other Name</th>
                                <th>Code</th>
                                <th>Zones</th>
                                <th>Addresses</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cities as $city)
                                <tr>
                                    <td>{{ $city->id }}</td>
                                    <td><code>{{ $city->cityId }}</code></td>
                                    <td><strong>{{ $city->cityName }}</strong></td>
                                    <td>{{ $city->cityOtherName ?: 'N/A' }}</td>
                                    <td><span class="badge bg-info">{{ $city->cityCode }}</span></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $city->zones_count }} zones</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $city->addresses_count }} addresses</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light me-1" onclick="editCity({{ $city->id }}, '{{ $city->cityId }}', '{{ $city->cityName }}', '{{ $city->cityOtherName }}', '{{ $city->cityCode }}')">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCity({{ $city->id }}, '{{ $city->cityName }}')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-5 text-center">
                                        <i class="ti ti-building-community" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2 text-muted">No cities found</p>
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
