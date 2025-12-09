<div class="modal fade" id="editDistrictModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editDistrictForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-edit me-2"></i>Edit District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_district_city_id" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_district_city_id" onchange="loadEditDistrictZones(this.value)">
                                <option value="">Select City</option>
                                @foreach(\App\Models\City::orderBy('cityName')->get() as $city)
                                    <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_zone_id" class="form-label">Zone <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_zone_id" name="zone_id" required>
                                <option value="">Select City First</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_districtId" class="form-label">District ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_districtId" name="districtId" required placeholder="e.g., D001">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_districtName" class="form-label">District Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_districtName" name="districtName" required placeholder="e.g., District 1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_districtOtherName" class="form-label">District Other Name</label>
                        <input type="text" class="form-control" id="edit_districtOtherName" name="districtOtherName" placeholder="Alternative name">
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
                        <i class="ti ti-check me-1"></i>Update District
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function loadEditDistrictZones(cityId, selectedZoneId = null) {
        const zoneSelect = document.getElementById('edit_zone_id');
        
        zoneSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (!cityId) {
            zoneSelect.innerHTML = '<option value="">Select City First</option>';
            return;
        }
        
        fetch(`/admin/locations/zones/${cityId}`)
            .then(response => response.json())
            .then(zones => {
                zoneSelect.innerHTML = '<option value="">Select Zone</option>';
                zones.forEach(zone => {
                    const option = document.createElement('option');
                    option.value = zone.id;
                    option.textContent = zone.zoneName;
                    if (selectedZoneId && zone.id == selectedZoneId) {
                        option.selected = true;
                    }
                    zoneSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading zones:', error);
                zoneSelect.innerHTML = '<option value="">Error loading zones</option>';
            });
    }

    function editDistrict(id, cityId, zoneId, districtId, districtName, districtOtherName, pickupAvailability, dropOffAvailability, isActive) {
        document.getElementById('edit_district_city_id').value = cityId;
        loadEditDistrictZones(cityId, zoneId);
        
        document.getElementById('edit_districtId').value = districtId;
        document.getElementById('edit_districtName').value = districtName;
        document.getElementById('edit_districtOtherName').value = districtOtherName || '';
        document.getElementById('edit_pickupAvailability').checked = pickupAvailability;
        document.getElementById('edit_dropOffAvailability').checked = dropOffAvailability;
        document.getElementById('edit_is_active').checked = isActive;
        document.getElementById('editDistrictForm').action = `/admin/districts/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editDistrictModal'));
        modal.show();
    }
</script>
