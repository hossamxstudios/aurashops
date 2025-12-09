<div class="modal fade" id="addZoneModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addZoneForm">
                @csrf
                <input type="hidden" id="add_zone_city_id" name="city_id">
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="plus" class="me-2"></i>Add Zone with Districts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i data-lucide="info" class="me-2"></i>
                        <small>Add a new zone and optionally add multiple districts to it.</small>
                    </div>

                    <!-- Zone Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Zone Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="add_zone_zoneId" class="form-label">Zone ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="add_zone_zoneId" name="zoneId" required placeholder="Z001">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="add_zone_zoneName" class="form-label">Zone Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="add_zone_zoneName" name="zoneName" required placeholder="Downtown">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="add_zone_zoneOtherName" class="form-label">Zone Other Name</label>
                                <input type="text" class="form-control" id="add_zone_zoneOtherName" name="zoneOtherName" placeholder="Alternative name">
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="add_zone_pickupAvailability" name="pickupAvailability" value="1" checked>
                                        <label class="form-check-label" for="add_zone_pickupAvailability">Pickup Available</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="add_zone_dropOffAvailability" name="dropOffAvailability" value="1" checked>
                                        <label class="form-check-label" for="add_zone_dropOffAvailability">Drop-off Available</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="add_zone_is_active" name="is_active" value="1" checked>
                                        <label class="form-check-label" for="add_zone_is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Districts -->
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Districts (Optional)</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="addNewDistrictRow()">
                                <i data-lucide="plus" class="icon-sm me-1"></i>Add District
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="newDistrictsContainer"></div>
                            <p class="text-muted text-center mb-0" id="noNewDistrictsMessage">Click "Add District" to add districts to this zone</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check" class="me-1"></i>Create Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentCityIdForNewZone = null;
    let newDistrictIndex = 0;

    function openAddZoneModal() {
        const cityIdInput = document.getElementById('add_zone_city_id');

        // Get city ID from global variable
        if (window.currentViewingCityId) {
            currentCityIdForNewZone = window.currentViewingCityId;
            cityIdInput.value = window.currentViewingCityId;
        }

        // Reset form
        document.getElementById('addZoneForm').reset();
        document.getElementById('newDistrictsContainer').innerHTML = '';
        document.getElementById('noNewDistrictsMessage').style.display = 'block';
        newDistrictIndex = 0;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('addZoneModal'));
        modal.show();

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function addNewDistrictRow() {
        document.getElementById('noNewDistrictsMessage').style.display = 'none';
        const container = document.getElementById('newDistrictsContainer');

        const row = `
            <div class="row mb-2 district-row align-items-center border-bottom pb-2">
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" name="districts[${newDistrictIndex}][districtId]" required placeholder="D001">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="districts[${newDistrictIndex}][districtName]" required placeholder="District Name">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="districts[${newDistrictIndex}][districtOtherName]" placeholder="Other Name">
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="districts[${newDistrictIndex}][pickupAvailability]" value="1" checked>
                            <label class="form-check-label small">Pickup</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="districts[${newDistrictIndex}][dropOffAvailability]" value="1" checked>
                            <label class="form-check-label small">Drop-off</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.district-row').remove(); checkIfNoDistricts();">
                        <i data-lucide="x"></i>
                    </button>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', row);
        newDistrictIndex++;

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function checkIfNoDistricts() {
        const container = document.getElementById('newDistrictsContainer');
        if (container.children.length === 0) {
            document.getElementById('noNewDistrictsMessage').style.display = 'block';
        }
    }

    document.getElementById('addZoneForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        fetch('/admin/locations/zones/create', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('addZoneModal')).hide();
                // Reload the page to show updates
                window.location.reload();
            } else {
                alert(data.message || 'Failed to create zone');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to create zone');
        });
    });
</script>
