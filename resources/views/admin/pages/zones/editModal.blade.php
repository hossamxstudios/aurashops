<div class="modal fade" id="editZoneModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editZoneForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-edit me-2"></i>Edit Zone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_city_id" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_city_id" name="city_id" required>
                                <option value="">Select City</option>
                                @foreach(\App\Models\City::orderBy('cityName')->get() as $city)
                                    <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_zoneId" class="form-label">Zone ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_zoneId" name="zoneId" required placeholder="e.g., Z001">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_zoneName" class="form-label">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_zoneName" name="zoneName" required placeholder="e.g., Nasr City">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_zoneOtherName" class="form-label">Zone Other Name</label>
                            <input type="text" class="form-control" id="edit_zoneOtherName" name="zoneOtherName" placeholder="Alternative name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_pickupAvailability" name="pickupAvailability" value="1">
                                <label class="form-check-label" for="edit_pickupAvailability">
                                    Pickup Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_dropOffAvailability" name="dropOffAvailability" value="1">
                                <label class="form-check-label" for="edit_dropOffAvailability">
                                    Drop-off Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Update Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editZone(id, cityId, zoneId, zoneName, zoneOtherName, pickupAvailability, dropOffAvailability, isActive) {
        document.getElementById('edit_city_id').value = cityId;
        document.getElementById('edit_zoneId').value = zoneId;
        document.getElementById('edit_zoneName').value = zoneName;
        document.getElementById('edit_zoneOtherName').value = zoneOtherName || '';
        document.getElementById('edit_pickupAvailability').checked = pickupAvailability;
        document.getElementById('edit_dropOffAvailability').checked = dropOffAvailability;
        document.getElementById('edit_is_active').checked = isActive;
        document.getElementById('editZoneForm').action = `/admin/zones/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editZoneModal'));
        modal.show();
    }
</script>
