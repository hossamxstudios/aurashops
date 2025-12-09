<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.pickup-locations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Pickup Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" required>
                                <option value="store">Store</option>
                                <option value="warehouse">Warehouse</option>
                                <option value="depot">Depot</option>
                                <option value="branch">Branch</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Warehouse</label>
                            <select class="form-select" name="warehouse_id">
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Location Details</h6>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">City</label>
                            <select class="form-select" name="city_id" id="create_city_id">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Zone</label>
                            <select class="form-select" name="zone_id" id="create_zone_id" disabled>
                                <option value="">Select City First</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">District</label>
                            <select class="form-select" name="district_id" id="create_district_id" disabled>
                                <option value="">Select Zone First</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="full_address" rows="2" placeholder="e.g., 123 Main Street, Building A" required></textarea>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Working Hours</label>
                            <input type="text" class="form-control" name="working_hours" placeholder="e.g., Mon-Fri 9AM-6PM">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Zip Code</label>
                            <input type="text" class="form-control" name="zip_code" placeholder="e.g., 12345">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Contact Person</h6>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="contact_person_name" placeholder="e.g., John Doe">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="contact_person_phone" placeholder="e.g., +1234567890">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_person_email" placeholder="e.g., contact@example.com">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Coordinates (Optional)</h6>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.00000001" class="form-control" name="lat" placeholder="e.g., 40.7128">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.00000001" class="form-control" name="lng" placeholder="e.g., -74.0060">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="create_is_active" name="is_active" value="1" checked>
                                <label class="form-check-label" for="create_is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="create_is_default" name="is_default" value="1">
                                <label class="form-check-label" for="create_is_default">
                                    Set as Default
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Pickup Location</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for searchable dropdowns
    let createCityChoices, createZoneChoices, createDistrictChoices;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize City dropdown with search
        createCityChoices = new Choices('#create_city_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search cities...',
            itemSelectText: '',
            shouldSort: false
        });

        // Initialize Zone dropdown with search (disabled initially)
        createZoneChoices = new Choices('#create_zone_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search zones...',
            itemSelectText: '',
            shouldSort: false
        });

        // Initialize District dropdown with search (disabled initially)
        createDistrictChoices = new Choices('#create_district_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search districts...',
            itemSelectText: '',
            shouldSort: false
        });
    });

    // Create Modal - Cascading Dropdowns
    document.getElementById('create_city_id').addEventListener('change', function() {
        const cityId = this.value;

        // Reset zones and districts using Choices.js
        createZoneChoices.clearStore();
        createZoneChoices.setChoices([{value: '', label: 'Select Zone', selected: true}], 'value', 'label', true);
        createDistrictChoices.clearStore();
        createDistrictChoices.setChoices([{value: '', label: 'Select Zone First', selected: true}], 'value', 'label', true);
        createDistrictChoices.disable();

        if (cityId) {
            // Enable and load zones
            createZoneChoices.enable();

            fetch(`/admin/pickup-locations/zones/${cityId}`)
                .then(response => response.json())
                .then(zones => {
                    if (zones.length === 0) {
                        createZoneChoices.setChoices([{value: '', label: 'No zones available', selected: true}], 'value', 'label', true);
                    } else {
                        const zoneOptions = zones.map(zone => ({
                            value: zone.id.toString(),
                            label: zone.zoneName
                        }));
                        createZoneChoices.setChoices([
                            {value: '', label: 'Select Zone', selected: true},
                            ...zoneOptions
                        ], 'value', 'label', true);
                    }
                })
                .catch(error => {
                    console.error('Error loading zones:', error);
                    createZoneChoices.setChoices([{value: '', label: 'Error loading zones', selected: true}], 'value', 'label', true);
                });
        } else {
            createZoneChoices.disable();
        }
    });

    document.getElementById('create_zone_id').addEventListener('change', function() {
        const zoneId = this.value;

        // Reset districts using Choices.js
        createDistrictChoices.clearStore();
        createDistrictChoices.setChoices([{value: '', label: 'Select District', selected: true}], 'value', 'label', true);
        createDistrictChoices.disable();

        if (zoneId) {
            // Enable and load districts
            createDistrictChoices.enable();

            fetch(`/admin/pickup-locations/districts/${zoneId}`)
                .then(response => response.json())
                .then(districts => {
                    if (districts.length === 0) {
                        createDistrictChoices.setChoices([{value: '', label: 'No districts available', selected: true}], 'value', 'label', true);
                    } else {
                        const districtOptions = districts.map(district => ({
                            value: district.id.toString(),
                            label: district.districtName
                        }));
                        createDistrictChoices.setChoices([
                            {value: '', label: 'Select District', selected: true},
                            ...districtOptions
                        ], 'value', 'label', true);
                    }
                })
                .catch(error => {
                    console.error('Error loading districts:', error);
                    createDistrictChoices.setChoices([{value: '', label: 'Error loading districts', selected: true}], 'value', 'label', true);
                });
        } else {
            createDistrictChoices.disable();
        }
    });
</script>
