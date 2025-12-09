<div class="modal fade" id="editDistrictModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editDistrictForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="edit" class="me-2"></i>Edit District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_district_districtId" class="form-label">District ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_district_districtId" name="districtId" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_district_districtName" class="form-label">District Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_district_districtName" name="districtName" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_district_districtOtherName" class="form-label">District Other Name</label>
                        <input type="text" class="form-control" id="edit_district_districtOtherName" name="districtOtherName">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_district_pickupAvailability" name="pickupAvailability" value="1">
                                <label class="form-check-label" for="edit_district_pickupAvailability">
                                    Pickup Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_district_dropOffAvailability" name="dropOffAvailability" value="1">
                                <label class="form-check-label" for="edit_district_dropOffAvailability">
                                    Drop-off Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_district_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_district_is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check" class="me-1"></i>Update District
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentCityIdForDistrict = null;

    function editDistrictInCity(districtId, zoneId, districtIdCode, districtName, districtOtherName, pickupAvailability, dropOffAvailability, isActive, cityId) {
        currentCityIdForDistrict = cityId;
        
        document.getElementById('edit_district_districtId').value = districtIdCode;
        document.getElementById('edit_district_districtName').value = districtName;
        document.getElementById('edit_district_districtOtherName').value = districtOtherName || '';
        document.getElementById('edit_district_pickupAvailability').checked = pickupAvailability;
        document.getElementById('edit_district_dropOffAvailability').checked = dropOffAvailability;
        document.getElementById('edit_district_is_active').checked = isActive;
        document.getElementById('editDistrictForm').action = `/admin/locations/districts/${districtId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editDistrictModal'));
        modal.show();
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    document.getElementById('editDistrictForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        fetch(this.action, {
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
                bootstrap.Modal.getInstance(document.getElementById('editDistrictModal')).hide();
                // Reload the page to show updates
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update district');
        });
    });
</script>
