<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - {{ $city->cityName }} Details</title>
    <style>
        .icon-sm {
            width: 16px;
            height: 16px;
        }

        .bg-success-subtle {
            background-color: #d1f3d1 !important;
        }

        .bg-info-subtle {
            background-color: #cfe2ff !important;
        }

        .border-success {
            border-color: #198754 !important;
        }

        .border-info {
            border-color: #0dcaf0 !important;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                     <div class="py-2 pt-4 row justify-content-center">
                        <div class="text-center col-xxl-5 col-xl-7">
                            <a href="{{ route('admin.locations.index') }}" class="mb-2 btn btn-sm btn-light">
                                        <i data-lucide="arrow-left" class="icon-sm me-1"></i>Back to Locations
                                    </a>
                            <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" onclick="editCity({{ $city->id }})">
                                <i data-lucide="edit" class="fs-sm me-1"></i> Edit City
                            </span>
                            <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" onclick="deleteCity({{ $city->id }}, '{{ addslashes($city->cityName) }}')">
                                <i data-lucide="trash-2" class="fs-sm me-1"></i> Delete City
                            </span>
                            <h3 class="fw-bold">
                                City : {{ $city->cityName }}
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

                    <!-- City Stats -->
                    <div class="mb-4 row g-3">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <small class="mb-1 text-muted d-block">City ID</small>
                                    <code class="fs-6">{{ $city->cityId }}</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <small class="mb-1 text-muted d-block">City Code</small>
                                    <span class="badge bg-primary fs-6">{{ $city->cityCode }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <small class="mb-1 text-muted d-block">Total Zones</small>
                                    <span class="fs-5 fw-semibold">{{ $city->zones->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <small class="mb-1 text-muted d-block">Total Districts</small>
                                    <span class="fs-5 fw-semibold">{{ $city->zones->sum(fn($z) => $z->districts->count()) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Zones & Districts -->
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Zones & Districts</h5>
                                <button class="btn btn-sm btn-primary" onclick="openAddZoneModal()">
                                    <i data-lucide="plus" class="icon-sm me-1"></i>Add Zone
                                </button>
                            </div>

                            <!-- Search Zones -->
                            <div class="mb-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                    <input type="text" id="searchZones" class="form-control" placeholder="Search zones by name or ID...">
                                </div>
                            </div>

                            <div class="row">

                            @forelse($city->zones as $zone)
                                <div class="overflow-hidden mb-3 rounded border zone-card col-6" data-zone-name="{{ strtolower($zone->zoneName) }}" data-zone-id="{{ strtolower($zone->zoneId) }}">
                                    <div class="p-3 bg-light border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="gap-2 mb-1 d-flex align-items-center">
                                                    <h6 class="mb-0 fw-semibold">{{ $zone->zoneName }}</h6>
                                                    @if($zone->zoneOtherName)
                                                        <small class="text-muted">({{ $zone->zoneOtherName }})</small>
                                                    @endif
                                                </div>
                                                <div class="gap-2 d-flex align-items-center">
                                                    <code class="small">{{ $zone->zoneId }}</code>
                                                    <span class="border badge bg-light text-dark">{{ $zone->districts->count() }} districts</span>
                                                    @if($zone->pickupAvailability)
                                                        <span class="badge bg-success-subtle text-success border-success">Pickup</span>
                                                    @endif
                                                    @if($zone->dropOffAvailability)
                                                        <span class="badge bg-info-subtle text-info border-info">Drop-off</span>
                                                    @endif
                                                    @if($zone->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="gap-1 d-flex">
                                                <button class="btn btn-sm btn-success" onclick="openAddDistrictsModal({{ $zone->id }}, '{{ addslashes($zone->zoneName) }}', {{ $city->id }})">
                                                    <i data-lucide="plus" class="icon-sm"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light" onclick="editZoneInCity({{ $zone->id }}, '{{ addslashes($zone->zoneId) }}', '{{ addslashes($zone->zoneName) }}', '{{ addslashes($zone->zoneOtherName) }}', {{ $zone->pickupAvailability ? 'true' : 'false' }}, {{ $zone->dropOffAvailability ? 'true' : 'false' }}, {{ $zone->is_active ? 'true' : 'false' }}, {{ $city->id }})">
                                                    <i data-lucide="edit" class="icon-sm"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteZoneInCity({{ $zone->id }}, '{{ addslashes($zone->zoneName) }}', {{ $city->id }})">
                                                    <i data-lucide="trash-2" class="icon-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3">
                                        @if($zone->districts->count() > 0)
                                            <!-- Search Districts -->
                                            <div class="mb-2">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                                    <input type="text" class="form-control search-districts" placeholder="Search districts..." data-zone-id="{{ $zone->id }}">
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table mb-0 table-sm table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="100">ID</th>
                                                            <th>District Name</th>
                                                            <th width="150">Options</th>
                                                            <th width="80">Status</th>
                                                            <th width="100" class="text-center">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="districts-tbody" data-zone-id="{{ $zone->id }}">
                                                        @foreach($zone->districts as $district)
                                                            <tr class="district-row" data-district-name="{{ strtolower($district->districtName) }}" data-district-id="{{ strtolower($district->districtId) }}">
                                                                <td><code class="small">{{ $district->districtId }}</code></td>
                                                                <td>
                                                                    <div class="fw-semibold">{{ $district->districtName }}</div>
                                                                    @if($district->districtOtherName)
                                                                        <small class="text-muted">{{ $district->districtOtherName }}</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="gap-1 d-flex">
                                                                        @if($district->pickupAvailability)
                                                                            <span class="badge bg-success-subtle text-success border-success small">Pickup</span>
                                                                        @endif
                                                                        @if($district->dropOffAvailability)
                                                                            <span class="badge bg-info-subtle text-info border-info small">Drop-off</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @if($district->is_active)
                                                                        <span class="badge bg-success small">Active</span>
                                                                    @else
                                                                        <span class="badge bg-secondary small">Inactive</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="gap-1 d-flex justify-content-center">
                                                                        <button class="btn btn-sm btn-light" onclick="editDistrictInCity({{ $district->id }}, {{ $zone->id }}, '{{ addslashes($district->districtId) }}', '{{ addslashes($district->districtName) }}', '{{ addslashes($district->districtOtherName) }}', {{ $district->pickupAvailability ? 'true' : 'false' }}, {{ $district->dropOffAvailability ? 'true' : 'false' }}, {{ $district->is_active ? 'true' : 'false' }}, {{ $city->id }})">
                                                                            <i data-lucide="edit" class="icon-sm"></i>
                                                                        </button>
                                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDistrictInCity({{ $district->id }}, '{{ addslashes($district->districtName) }}', {{ $city->id }})">
                                                                            <i data-lucide="trash-2" class="icon-sm"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="py-3 mb-0 text-center text-muted">No districts in this zone</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="py-5 text-center text-muted">No zones found for this city</p>
                            @endforelse
                            </div>

                        </div>
                    </div>

                    <!-- Include Modals -->
                    @include('admin.pages.locations.editModal')
                    @include('admin.pages.locations.deleteModal')
                    @include('admin.pages.locations.editZoneModal')
                    @include('admin.pages.locations.deleteZoneModal')
                    @include('admin.pages.locations.editDistrictModal')
                    @include('admin.pages.locations.deleteDistrictModal')
                    @include('admin.pages.locations.addZoneModal')
                    @include('admin.pages.locations.addDistrictsModal')
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <script>
        // Store current city ID globally
        window.currentViewingCityId = {{ $city->id }};

        // Search zones
        document.getElementById('searchZones').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const zoneCards = document.querySelectorAll('.zone-card');

            zoneCards.forEach(card => {
                const zoneName = card.getAttribute('data-zone-name') || '';
                const zoneId = card.getAttribute('data-zone-id') || '';

                if (zoneName.includes(searchTerm) || zoneId.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Search districts within zones
        document.querySelectorAll('.search-districts').forEach(input => {
            input.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const zoneId = this.getAttribute('data-zone-id');
                const tbody = document.querySelector(`.districts-tbody[data-zone-id="${zoneId}"]`);

                if (!tbody) return;

                const rows = tbody.querySelectorAll('.district-row');

                rows.forEach(row => {
                    const districtName = row.getAttribute('data-district-name') || '';
                    const districtId = row.getAttribute('data-district-id') || '';

                    if (districtName.includes(searchTerm) || districtId.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
</body>
</html>
