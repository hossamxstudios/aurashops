<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pickup Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" id="edit_type" required>
                                <option value="store">Store</option>
                                <option value="warehouse">Warehouse</option>
                                <option value="depot">Depot</option>
                                <option value="branch">Branch</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warehouse</label>
                            <select class="form-select" name="warehouse_id" id="edit_warehouse_id">
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Location Details</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city_id" id="edit_city_id">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Zone</label>
                            <select class="form-select" name="zone_id" id="edit_zone_id" disabled>
                                <option value="">Select City First</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">District</label>
                            <select class="form-select" name="district_id" id="edit_district_id" disabled>
                                <option value="">Select Zone First</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="full_address" id="edit_full_address" rows="2" placeholder="e.g., 123 Main Street, Building A" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Working Hours</label>
                            <input type="text" class="form-control" name="working_hours" id="edit_working_hours" placeholder="e.g., Mon-Fri 9AM-6PM">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Zip Code</label>
                            <input type="text" class="form-control" name="zip_code" id="edit_zip_code" placeholder="e.g., 12345">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Contact Person</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="contact_person_name" id="edit_contact_person_name" placeholder="e.g., John Doe">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="contact_person_phone" id="edit_contact_person_phone" placeholder="e.g., +1234567890">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_person_email" id="edit_contact_person_email" placeholder="e.g., contact@example.com">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Coordinates (Optional)</h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.00000001" class="form-control" name="lat" id="edit_lat" placeholder="e.g., 40.7128">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.00000001" class="form-control" name="lng" id="edit_lng" placeholder="e.g., -74.0060">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label" for="edit_is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="edit_is_default" name="is_default" value="1">
                                <label class="form-check-label" for="edit_is_default">
                                    Set as Default
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Pickup Location</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for searchable dropdowns
    let editCityChoices, editZoneChoices, editDistrictChoices;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize City dropdown with search
        editCityChoices = new Choices('#edit_city_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search cities...',
            itemSelectText: '',
            shouldSort: false
        });
        
        // Initialize Zone dropdown with search (disabled initially)
        editZoneChoices = new Choices('#edit_zone_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search zones...',
            itemSelectText: '',
            shouldSort: false
        });
        
        // Initialize District dropdown with search (disabled initially)
        editDistrictChoices = new Choices('#edit_district_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search districts...',
            itemSelectText: '',
            shouldSort: false
        });
    });

    function editLocation(id) {
        fetch(`/admin/pickup-locations/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/pickup-locations/${id}`;
                document.getElementById('edit_type').value = data.type;
                document.getElementById('edit_warehouse_id').value = data.warehouse_id || '';
                document.getElementById('edit_full_address').value = data.full_address;
                document.getElementById('edit_working_hours').value = data.working_hours || '';
                document.getElementById('edit_zip_code').value = data.zip_code || '';
                document.getElementById('edit_contact_person_name').value = data.contact_person_name || '';
                document.getElementById('edit_contact_person_phone').value = data.contact_person_phone || '';
                document.getElementById('edit_contact_person_email').value = data.contact_person_email || '';
                document.getElementById('edit_lat').value = data.lat || '';
                document.getElementById('edit_lng').value = data.lng || '';
                document.getElementById('edit_is_active').checked = data.is_active;
                document.getElementById('edit_is_default').checked = data.is_default;

                // Set city value using Choices.js
                editCityChoices.setChoiceByValue(data.city_id ? data.city_id.toString() : '');

                // Load zones if city is selected
                if (data.city_id) {
                    editZoneChoices.enable();
                    editZoneChoices.clearStore();
                    editZoneChoices.setChoices([{value: '', label: 'Loading zones...', selected: true}], 'value', 'label', true);
                    
                    fetch(`/admin/pickup-locations/zones/${data.city_id}`)
                        .then(response => response.json())
                        .then(zones => {
                            const zoneOptions = zones.map(zone => ({
                                value: zone.id.toString(),
                                label: zone.zoneName,
                                selected: zone.id == data.zone_id
                            }));
                            editZoneChoices.clearStore();
                            editZoneChoices.setChoices([
                                {value: '', label: 'Select Zone'},
                                ...zoneOptions
                            ], 'value', 'label', true);
                            
                            if (data.zone_id) {
                                editZoneChoices.setChoiceByValue(data.zone_id.toString());
                            }
                            
                            // Load districts if zone is selected
                            if (data.zone_id) {
                                editDistrictChoices.enable();
                                editDistrictChoices.clearStore();
                                editDistrictChoices.setChoices([{value: '', label: 'Loading districts...', selected: true}], 'value', 'label', true);
                                
                                fetch(`/admin/pickup-locations/districts/${data.zone_id}`)
                                    .then(response => response.json())
                                    .then(districts => {
                                        const districtOptions = districts.map(district => ({
                                            value: district.id.toString(),
                                            label: district.districtName,
                                            selected: district.id == data.district_id
                                        }));
                                        editDistrictChoices.clearStore();
                                        editDistrictChoices.setChoices([
                                            {value: '', label: 'Select District'},
                                            ...districtOptions
                                        ], 'value', 'label', true);
                                        
                                        if (data.district_id) {
                                            editDistrictChoices.setChoiceByValue(data.district_id.toString());
                                        }
                                    });
                            }
                        });
                }

                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load pickup location details');
            });
    }
    
    // Edit Modal - Cascading Dropdowns
    document.getElementById('edit_city_id').addEventListener('change', function() {
        const cityId = this.value;
        
        // Reset zones and districts using Choices.js
        editZoneChoices.clearStore();
        editZoneChoices.setChoices([{value: '', label: 'Select Zone', selected: true}], 'value', 'label', true);
        editDistrictChoices.clearStore();
        editDistrictChoices.setChoices([{value: '', label: 'Select Zone First', selected: true}], 'value', 'label', true);
        editDistrictChoices.disable();
        
        if (cityId) {
            // Enable and load zones
            editZoneChoices.enable();
            
            fetch(`/admin/pickup-locations/zones/${cityId}`)
                .then(response => response.json())
                .then(zones => {
                    if (zones.length === 0) {
                        editZoneChoices.setChoices([{value: '', label: 'No zones available', selected: true}], 'value', 'label', true);
                    } else {
                        const zoneOptions = zones.map(zone => ({
                            value: zone.id.toString(),
                            label: zone.zoneName
                        }));
                        editZoneChoices.setChoices([
                            {value: '', label: 'Select Zone', selected: true},
                            ...zoneOptions
                        ], 'value', 'label', true);
                    }
                })
                .catch(error => {
                    console.error('Error loading zones:', error);
                    editZoneChoices.setChoices([{value: '', label: 'Error loading zones', selected: true}], 'value', 'label', true);
                });
        } else {
            editZoneChoices.disable();
        }
    });
    
    document.getElementById('edit_zone_id').addEventListener('change', function() {
        const zoneId = this.value;
        
        // Reset districts using Choices.js
        editDistrictChoices.clearStore();
        editDistrictChoices.setChoices([{value: '', label: 'Select District', selected: true}], 'value', 'label', true);
        
        if (zoneId) {
            // Enable and load districts
            editDistrictChoices.enable();
            
            fetch(`/admin/pickup-locations/districts/${zoneId}`)
                .then(response => response.json())
                .then(districts => {
                    if (districts.length === 0) {
                        editDistrictChoices.setChoices([{value: '', label: 'No districts available', selected: true}], 'value', 'label', true);
                    } else {
                        const districtOptions = districts.map(district => ({
                            value: district.id.toString(),
                            label: district.districtName
                        }));
                        editDistrictChoices.setChoices([
                            {value: '', label: 'Select District', selected: true},
                            ...districtOptions
                        ], 'value', 'label', true);
                    }
                })
                .catch(error => {
                    console.error('Error loading districts:', error);
                    editDistrictChoices.setChoices([{value: '', label: 'Error loading districts', selected: true}], 'value', 'label', true);
                });
        } else {
            editDistrictChoices.disable();
        }
    });
</script>
