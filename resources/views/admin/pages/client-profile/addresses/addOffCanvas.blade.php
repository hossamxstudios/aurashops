<div class="offcanvas offcanvas-end" tabindex="-1" id="addAddressOffCanvas" style="width: 600px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.addresses.store') }}" method="POST">
            @csrf
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            
            <div class="mb-3">
                <label for="label" class="form-label">Label <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" required value="{{ old('label') }}" placeholder="e.g. Home, Office, Work">
                @error('label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" required value="{{ old('phone') }}" placeholder="+20 123 456 7890">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="full_address" class="form-label">Full Address <span class="text-danger">*</span></label>
                <textarea class="form-control @error('full_address') is-invalid @enderror" id="full_address" name="full_address" rows="2" required placeholder="Complete address as it should appear">{{ old('full_address') }}</textarea>
                @error('full_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="apartment" class="form-label">Apartment</label>
                    <input type="text" class="form-control @error('apartment') is-invalid @enderror" id="apartment" name="apartment" value="{{ old('apartment') }}" placeholder="Apt. 5">
                    @error('apartment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="floor" class="form-label">Floor</label>
                    <input type="text" class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" value="{{ old('floor') }}" placeholder="3rd Floor">
                    @error('floor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="building" class="form-label">Building <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('building') is-invalid @enderror" id="building" name="building" required value="{{ old('building') }}" placeholder="Building name or number">
                @error('building')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="street" class="form-label">Street <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" name="street" required value="{{ old('street') }}" placeholder="Street name">
                @error('street')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="add_city_id" class="form-label">City <span class="text-danger">*</span></label>
                <select class="form-select @error('city_id') is-invalid @enderror" id="add_city_id" name="city_id" required onchange="loadAddZones(this.value)">
                    <option value="">Select City</option>
                    @foreach(\App\Models\City::orderBy('cityName')->get() as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->cityName }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="add_zone_id" class="form-label">Zone <span class="text-danger">*</span></label>
                <select class="form-select @error('zone_id') is-invalid @enderror" id="add_zone_id" name="zone_id" required onchange="loadAddDistricts(this.value)">
                    <option value="">Select City First</option>
                </select>
                @error('zone_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="add_district_id" class="form-label">District <span class="text-danger">*</span></label>
                <select class="form-select @error('district_id') is-invalid @enderror" id="add_district_id" name="district_id" required>
                    <option value="">Select Zone First</option>
                </select>
                @error('district_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="zip_code" class="form-label">Zip Code</label>
                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="12345">
                @error('zip_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">
                
                <!-- Map Display -->
                <div id="addMapContainer" class="border rounded mb-2" style="height: 200px; display: none;">
                    <iframe id="addMapFrame" width="100%" height="100%" frameborder="0" style="border:0; border-radius: 0.25rem;"></iframe>
                </div>
                <div id="addNoLocation" class="text-center py-4 bg-light rounded">
                    <i class="ti ti-map-off text-muted fs-2"></i>
                    <p class="text-muted fs-sm mb-0 mt-2">No location set</p>
                </div>
                
                <button type="button" class="btn btn-light btn-sm w-100 mt-2" onclick="getMyLocation()">
                    <i class="ti ti-current-location me-1"></i>Use My Current Location
                </button>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_default">
                    Set as default address
                </label>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Add Address
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function loadAddZones(cityId) {
        const zoneSelect = document.getElementById('add_zone_id');
        const districtSelect = document.getElementById('add_district_id');
        
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
                    zoneSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading zones:', error);
                zoneSelect.innerHTML = '<option value="">Error loading zones</option>';
            });
    }
    
    function loadAddDistricts(zoneId) {
        const districtSelect = document.getElementById('add_district_id');
        
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
                    districtSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading districts:', error);
                districtSelect.innerHTML = '<option value="">Error loading districts</option>';
            });
    }

    function getMyLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
                updateAddMap(lat, lng);
            }, function(error) {
                alert('Unable to get your location. Please enter manually.');
            });
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    }
    
    function updateAddMap(lat, lng) {
        const mapContainer = document.getElementById('addMapContainer');
        const noLocation = document.getElementById('addNoLocation');
        const mapFrame = document.getElementById('addMapFrame');
        
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
