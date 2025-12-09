<div class="modal fade" id="addDistrictsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addDistrictsForm">
                @csrf
                <input type="hidden" id="add_districts_zone_id" name="zone_id">
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="plus" class="me-2"></i>Add Districts to <span id="add_districts_zone_name" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i data-lucide="info" class="me-2"></i>
                        <small>Add multiple districts to this zone at once.</small>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Districts</h6>
                            <button type="button" class="btn btn-sm btn-success" onclick="addDistrictRowToZone()">
                                <i data-lucide="plus" class="icon-sm me-1"></i>Add District
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="addDistrictsContainer"></div>
                            <p class="text-muted text-center mb-0" id="noAddDistrictsMessage">Click "Add District" to start adding districts</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check" class="me-1"></i>Add Districts
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentZoneIdForNewDistricts = null;
    let currentCityIdForNewDistricts = null;
    let addDistrictToZoneIndex = 0;

    function openAddDistrictsModal(zoneId, zoneName, cityId) {
        currentZoneIdForNewDistricts = zoneId;
        currentCityIdForNewDistricts = cityId;
        
        document.getElementById('add_districts_zone_id').value = zoneId;
        document.getElementById('add_districts_zone_name').textContent = zoneName;
        
        // Reset form
        document.getElementById('addDistrictsForm').reset();
        document.getElementById('addDistrictsContainer').innerHTML = '';
        document.getElementById('noAddDistrictsMessage').style.display = 'block';
        addDistrictToZoneIndex = 0;
        
        // Add one district row by default
        addDistrictRowToZone();
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('addDistrictsModal'));
        modal.show();
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function addDistrictRowToZone() {
        document.getElementById('noAddDistrictsMessage').style.display = 'none';
        const container = document.getElementById('addDistrictsContainer');
        
        const row = `
            <div class="row mb-2 district-row align-items-center border-bottom pb-2">
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" name="districts[${addDistrictToZoneIndex}][districtId]" required placeholder="D001">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="districts[${addDistrictToZoneIndex}][districtName]" required placeholder="District Name">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" name="districts[${addDistrictToZoneIndex}][districtOtherName]" placeholder="Other Name">
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="districts[${addDistrictToZoneIndex}][pickupAvailability]" value="1" checked>
                            <label class="form-check-label small">Pickup</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="districts[${addDistrictToZoneIndex}][dropOffAvailability]" value="1" checked>
                            <label class="form-check-label small">Drop-off</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.district-row').remove(); checkIfNoAddDistricts();">
                        <i data-lucide="x"></i>
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', row);
        addDistrictToZoneIndex++;
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function checkIfNoAddDistricts() {
        const container = document.getElementById('addDistrictsContainer');
        if (container.children.length === 0) {
            document.getElementById('noAddDistrictsMessage').style.display = 'block';
        }
    }

    document.getElementById('addDistrictsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        fetch('/admin/locations/districts/create-multiple', {
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
                bootstrap.Modal.getInstance(document.getElementById('addDistrictsModal')).hide();
                // Reload the page to show updates
                window.location.reload();
            } else {
                alert(data.message || 'Failed to add districts');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to add districts');
        });
    });
</script>
