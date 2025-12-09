<div class="offcanvas offcanvas-end" tabindex="-1" id="editAddressOffCanvas" style="width: 600px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Edit Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editAddressForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="edit_label" class="form-label">Label <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_label" name="label" required placeholder="e.g. Home, Office, Work">
            </div>

            <div class="mb-3">
                <label for="edit_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_phone" name="phone" required placeholder="+20 123 456 7890">
            </div>

            <div class="mb-3">
                <label for="edit_full_address" class="form-label">Full Address <span class="text-danger">*</span></label>
                <textarea class="form-control" id="edit_full_address" name="full_address" rows="2" required placeholder="Complete address as it should appear"></textarea>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="edit_apartment" class="form-label">Apartment</label>
                    <input type="text" class="form-control" id="edit_apartment" name="apartment" placeholder="Apt. 5">
                </div>

                <div class="mb-3 col-md-6">
                    <label for="edit_floor" class="form-label">Floor</label>
                    <input type="text" class="form-control" id="edit_floor" name="floor" placeholder="3rd Floor">
                </div>
            </div>

            <div class="mb-3">
                <label for="edit_building" class="form-label">Building <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_building" name="building" required placeholder="Building name or number">
            </div>

            <div class="mb-3">
                <label for="edit_street" class="form-label">Street <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_street" name="street" required placeholder="Street name">
            </div>

            <div class="mb-3">
                <label for="edit_city_id" class="form-label">City <span class="text-danger">*</span></label>
                <select class="form-select" id="edit_city_id" name="city_id" required onchange="loadEditZones(this.value)">
                    <option value="">Select City</option>
                    @foreach(\App\Models\City::orderBy('cityName')->get() as $city)
                        <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_zone_id" class="form-label">Zone <span class="text-danger">*</span></label>
                <select class="form-select" id="edit_zone_id" name="zone_id" required onchange="loadEditDistricts(this.value)">
                    <option value="">Select City First</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_district_id" class="form-label">District <span class="text-danger">*</span></label>
                <select class="form-select" id="edit_district_id" name="district_id" required>
                    <option value="">Select Zone First</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="edit_zip_code" class="form-label">Zip Code</label>
                <input type="text" class="form-control" id="edit_zip_code" name="zip_code" placeholder="12345">
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="hidden" id="edit_lat" name="lat">
                <input type="hidden" id="edit_lng" name="lng">
                
                <!-- Map Display -->
                <div id="editMapContainer" class="border rounded mb-2" style="height: 200px; display: none;">
                    <iframe id="editMapFrame" width="100%" height="100%" frameborder="0" style="border:0; border-radius: 0.25rem;"></iframe>
                </div>
                <div id="editNoLocation" class="text-center py-4 bg-light rounded">
                    <i class="ti ti-map-off text-muted fs-2"></i>
                    <p class="text-muted fs-sm mb-0 mt-2">No location set</p>
                </div>
                
                <button type="button" class="mt-2 btn btn-light btn-sm w-100" onclick="getEditLocation()">
                    <i class="ti ti-current-location me-1"></i>Use My Current Location
                </button>
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" id="edit_is_default" name="is_default" value="1">
                <label class="form-check-label" for="edit_is_default">
                    Set as default address
                </label>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Update Address
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function loadEditZones(cityId, selectedZoneId = null) {
        const zoneSelect = document.getElementById('edit_zone_id');
        const districtSelect = document.getElementById('edit_district_id');
        
        // Reset zone and district
        zoneSelect.innerHTML = '<option value="">Loading...</option>';
        districtSelect.innerHTML = '<option value="">Select Zone First</option>';
        
        if (!cityId) {
            zoneSelect.innerHTML = '<option value="">Select City First</option>';
            return;
        }
        
        // Fetch zones
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
                
                // If zone was pre-selected, load its districts
                if (selectedZoneId) {
                    loadEditDistricts(selectedZoneId);
                }
            })
            .catch(error => {
                console.error('Error loading zones:', error);
                zoneSelect.innerHTML = '<option value="">Error loading zones</option>';
            });
    }
    
    function loadEditDistricts(zoneId, selectedDistrictId = null) {
        const districtSelect = document.getElementById('edit_district_id');
        
        // Reset district
        districtSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (!zoneId) {
            districtSelect.innerHTML = '<option value="">Select Zone First</option>';
            return;
        }
        
        // Fetch districts
        fetch(`/admin/locations/districts/${zoneId}`)
            .then(response => response.json())
            .then(districts => {
                districtSelect.innerHTML = '<option value="">Select District</option>';
                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.districtName;
                    if (selectedDistrictId && district.id == selectedDistrictId) {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading districts:', error);
                districtSelect.innerHTML = '<option value="">Error loading districts</option>';
            });
    }

    function editAddress(addressId) {
        // Fetch address data
        fetch(`/admin/addresses/${addressId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_label').value = data.label || '';
                document.getElementById('edit_phone').value = data.phone || '';
                document.getElementById('edit_full_address').value = data.full_address;
                document.getElementById('edit_apartment').value = data.apartment || '';
                document.getElementById('edit_floor').value = data.floor || '';
                document.getElementById('edit_building').value = data.building;
                document.getElementById('edit_street').value = data.street;
                document.getElementById('edit_zip_code').value = data.zip_code || '';
                document.getElementById('edit_lat').value = data.lat || '';
                document.getElementById('edit_lng').value = data.lng || '';
                document.getElementById('edit_is_default').checked = data.is_default;
                
                // Set city and load cascading dropdowns
                document.getElementById('edit_city_id').value = data.city_id;
                if (data.city_id) {
                    loadEditZones(data.city_id, data.zone_id);
                }
                
                // Store district_id to select after zones/districts are loaded
                if (data.district_id) {
                    setTimeout(() => {
                        document.getElementById('edit_district_id').value = data.district_id;
                    }, 500);
                }
                
                // Update map display
                updateEditMap(data.lat, data.lng);

                // Set form action
                document.getElementById('editAddressForm').action = `/admin/addresses/${addressId}`;

                // Show offcanvas
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('editAddressOffCanvas'));
                offcanvas.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load address data');
            });
    }

    function getEditLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                document.getElementById('edit_lat').value = lat;
                document.getElementById('edit_lng').value = lng;
                updateEditMap(lat, lng);
            }, function(error) {
                alert('Unable to get your location. Please enter manually.');
            });
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    }
    
    function updateEditMap(lat, lng) {
        const mapContainer = document.getElementById('editMapContainer');
        const noLocation = document.getElementById('editNoLocation');
        const mapFrame = document.getElementById('editMapFrame');
        
        if (lat && lng) {
            // Show map, hide no-location message
            mapContainer.style.display = 'block';
            noLocation.style.display = 'none';
            
            // Update iframe src with Google Maps embed
            mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
        } else {
            // Hide map, show no-location message
            mapContainer.style.display = 'none';
            noLocation.style.display = 'block';
        }
    }
</script>
