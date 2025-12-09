<div class="modal fade" id="editZoneModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editZoneForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="edit" class="me-2"></i>Edit Zone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_zone_zoneId" class="form-label">Zone ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_zone_zoneId" name="zoneId" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_zone_zoneName" class="form-label">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_zone_zoneName" name="zoneName" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_zone_zoneOtherName" class="form-label">Zone Other Name</label>
                        <input type="text" class="form-control" id="edit_zone_zoneOtherName" name="zoneOtherName">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_zone_pickupAvailability" name="pickupAvailability" value="1">
                                <label class="form-check-label" for="edit_zone_pickupAvailability">
                                    Pickup Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_zone_dropOffAvailability" name="dropOffAvailability" value="1">
                                <label class="form-check-label" for="edit_zone_dropOffAvailability">
                                    Drop-off Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_zone_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_zone_is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check" class="me-1"></i>Update Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentCityIdForZone = null;

    function editZoneInCity(zoneId, zoneIdCode, zoneName, zoneOtherName, pickupAvailability, dropOffAvailability, isActive, cityId) {
        currentCityIdForZone = cityId;
        
        document.getElementById('edit_zone_zoneId').value = zoneIdCode;
        document.getElementById('edit_zone_zoneName').value = zoneName;
        document.getElementById('edit_zone_zoneOtherName').value = zoneOtherName || '';
        document.getElementById('edit_zone_pickupAvailability').checked = pickupAvailability;
        document.getElementById('edit_zone_dropOffAvailability').checked = dropOffAvailability;
        document.getElementById('edit_zone_is_active').checked = isActive;
        document.getElementById('editZoneForm').action = `/admin/locations/zones/${zoneId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editZoneModal'));
        modal.show();
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    document.getElementById('editZoneForm').addEventListener('submit', function(e) {
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
                bootstrap.Modal.getInstance(document.getElementById('editZoneModal')).hide();
                // Reload the page to show updates
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update zone');
        });
    });
</script>
