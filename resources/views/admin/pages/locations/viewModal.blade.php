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

<div class="modal fade" id="viewCityModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="pb-0 border-0 modal-header">
                <div>
                    <h4 id="view_cityName" class="mb-1 fw-bold"></h4>
                    <p class="mb-0 text-muted small" id="view_cityOtherName"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="pt-2 modal-body">
                <!-- City Info Stats -->
                <div class="mb-4 row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="mb-1 text-muted d-block">City ID</small>
                            <code class="fs-6" id="view_cityId"></code>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="mb-1 text-muted d-block">City Code</small>
                            <span class="badge bg-primary fs-6" id="view_cityCode"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="mb-1 text-muted d-block">Total Zones</small>
                            <span class="fs-5 fw-semibold" id="view_zonesCount">-</span>
                        </div>
                    </div>
                </div>

                <!-- Zones & Districts -->
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">Zones & Districts</h6>
                    <button class="btn btn-sm btn-primary" onclick="openAddZoneModal()" title="Add New Zone">
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

                <div id="view_zonesContainer">
                    <div class="py-5 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading zones and districts...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function viewCity(cityId) {
        // Store current city ID globally for add zone/districts modals
        window.currentViewingCityId = cityId;

        fetch(`/admin/locations/${cityId}/view`)
            .then(response => response.json())
            .then(data => {
                // Populate city info
                document.getElementById('view_cityName').textContent = data.cityName;
                document.getElementById('view_cityOtherName').textContent = data.cityOtherName || '';
                document.getElementById('view_cityId').textContent = data.cityId;
                document.getElementById('view_cityCode').textContent = data.cityCode;
                document.getElementById('view_zonesCount').textContent = data.zones ? data.zones.length : 0;

                // Populate zones and districts
                const container = document.getElementById('view_zonesContainer');

                if (data.zones && data.zones.length > 0) {
                    let html = '';

                    data.zones.forEach((zone, index) => {
                        html += `
                            <div class="overflow-hidden mb-3 rounded border zone-card" data-zone-name="${zone.zoneName.toLowerCase()}" data-zone-id="${zone.zoneId.toLowerCase()}">
                                <div class="p-3 bg-light border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="gap-2 mb-1 d-flex align-items-center">
                                                <h6 class="mb-0 fw-semibold">${zone.zoneName}</h6>
                                                ${zone.zoneOtherName ? `<small class="text-muted">(${zone.zoneOtherName})</small>` : ''}
                                            </div>
                                            <div class="gap-2 d-flex align-items-center">
                                                <code class="small">${zone.zoneId}</code>
                                                <span class="border badge bg-light text-dark">${zone.districts_count} districts</span>
                                                ${zone.pickupAvailability ? '<span class="badge bg-success-subtle text-success border-success">Pickup</span>' : ''}
                                                ${zone.dropOffAvailability ? '<span class="badge bg-info-subtle text-info border-info">Drop-off</span>' : ''}
                                                ${zone.is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'}
                                            </div>
                                        </div>
                                        <div class="gap-1 d-flex">
                                            <button class="btn btn-sm btn-success" onclick="openAddDistrictsModal(${zone.id}, '${zone.zoneName.replace(/'/g, "\\'")}', ${data.id})" title="Add Districts">
                                                <i data-lucide="plus" class="icon-sm"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light" onclick="editZoneInCity(${zone.id}, '${zone.zoneId.replace(/'/g, "\\'")}', '${zone.zoneName.replace(/'/g, "\\'")}', '${(zone.zoneOtherName || '').replace(/'/g, "\\'")}', ${zone.pickupAvailability}, ${zone.dropOffAvailability}, ${zone.is_active}, ${data.id})" title="Edit Zone">
                                                <i data-lucide="edit" class="icon-sm"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteZoneInCity(${zone.id}, '${zone.zoneName.replace(/'/g, "\\'")}', ${data.id})" title="Delete Zone">
                                                <i data-lucide="trash-2" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    ${zone.districts && zone.districts.length > 0 ? `
                                        <div class="mb-2">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                                <input type="text" class="form-control search-districts" placeholder="Search districts..." data-zone-id="${zone.id}">
                                            </div>
                                        </div>
                                    ` : ''}
                                    ${zone.districts && zone.districts.length > 0 ? `
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
                                                <tbody class="districts-tbody" data-zone-id="${zone.id}">
                                                    ${zone.districts.map(district => `
                                                        <tr class="district-row" data-district-name="${district.districtName.toLowerCase()}" data-district-id="${district.districtId.toLowerCase()}">
                                                            <td><code class="small">${district.districtId}</code></td>
                                                            <td>
                                                                <div class="fw-semibold">${district.districtName}</div>
                                                                ${district.districtOtherName ? `<small class="text-muted">${district.districtOtherName}</small>` : ''}
                                                            </td>
                                                            <td>
                                                                <div class="gap-1 d-flex">
                                                                    ${district.pickupAvailability ? '<span class="badge bg-success-subtle text-success border-success small">Pickup</span>' : ''}
                                                                    ${district.dropOffAvailability ? '<span class="badge bg-info-subtle text-info border-info small">Drop-off</span>' : ''}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                ${district.is_active ? '<span class="badge bg-success small">Active</span>' : '<span class="badge bg-secondary small">Inactive</span>'}
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="gap-1 d-flex justify-content-center">
                                                                    <button class="btn btn-sm btn-light" onclick="editDistrictInCity(${district.id}, ${zone.id}, '${district.districtId.replace(/'/g, "\\'")}', '${district.districtName.replace(/'/g, "\\'")}', '${(district.districtOtherName || '').replace(/'/g, "\\'")}', ${district.pickupAvailability}, ${district.dropOffAvailability}, ${district.is_active}, ${data.id})" title="Edit District">
                                                                        <i data-lucide="edit" class="icon-sm"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteDistrictInCity(${district.id}, '${district.districtName.replace(/'/g, "\\'")}', ${data.id})" title="Delete District">
                                                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                    ` : '<p class="py-3 mb-0 text-center text-muted">No districts in this zone</p>'}
                                </div>
                            </div>
                        `;
                    });

                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p class="text-center text-muted">No zones found for this city</p>';
                }

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewCityModal'));
                modal.show();

                // Re-initialize Lucide icons
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                // Setup search filters after content is loaded
                setupZoneSearch();
                setupDistrictSearches();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load city details');
            });
    }

    // Search zones function
    function setupZoneSearch() {
        const searchInput = document.getElementById('searchZones');
        if (!searchInput) return;

        searchInput.addEventListener('input', function() {
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
    }

    // Search districts within zones
    function setupDistrictSearches() {
        const districtSearchInputs = document.querySelectorAll('.search-districts');

        districtSearchInputs.forEach(input => {
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
    }

    // Fix modal stacking issue - adjust backdrop z-index when multiple modals are open
    document.addEventListener('DOMContentLoaded', function() {
        let modalCount = 0;

        // When a modal is shown
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('show.bs.modal', function() {
                modalCount++;
                const zIndex = 1050 + (10 * modalCount);
                this.style.zIndex = zIndex;

                setTimeout(() => {
                    const backdrop = document.querySelectorAll('.modal-backdrop');
                    if (backdrop.length > 0) {
                        backdrop[backdrop.length - 1].style.zIndex = zIndex - 1;
                    }
                }, 0);
            });

            // When a modal is hidden
            modal.addEventListener('hidden.bs.modal', function() {
                modalCount--;

                // If there are still modals open, make sure body has modal-open class
                if (modalCount > 0) {
                    document.body.classList.add('modal-open');
                }
            });
        });
    });
</script>
