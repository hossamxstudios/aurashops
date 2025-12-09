<div class="modal fade" id="createDistrictModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.districts.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-map-2 me-2"></i>Add New District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="create_city_id" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-select @error('city_id') is-invalid @enderror" id="create_city_id" onchange="loadCreateZones(this.value)">
                                <option value="">Select City</option>
                                @foreach(\App\Models\City::orderBy('cityName')->get() as $city)
                                    <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="zone_id" class="form-label">Zone <span class="text-danger">*</span></label>
                            <select class="form-select @error('zone_id') is-invalid @enderror" id="zone_id" name="zone_id" required>
                                <option value="">Select City First</option>
                            </select>
                            @error('zone_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="districtId" class="form-label">District ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('districtId') is-invalid @enderror" id="districtId" name="districtId" required value="{{ old('districtId') }}" placeholder="e.g., D001">
                            @error('districtId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="districtName" class="form-label">District Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('districtName') is-invalid @enderror" id="districtName" name="districtName" required value="{{ old('districtName') }}" placeholder="e.g., District 1">
                            @error('districtName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="districtOtherName" class="form-label">District Other Name</label>
                        <input type="text" class="form-control @error('districtOtherName') is-invalid @enderror" id="districtOtherName" name="districtOtherName" value="{{ old('districtOtherName') }}" placeholder="Alternative name">
                        @error('districtOtherName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="pickupAvailability" name="pickupAvailability" value="1" {{ old('pickupAvailability') ? 'checked' : '' }}>
                                <label class="form-check-label" for="pickupAvailability">
                                    Pickup Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="dropOffAvailability" name="dropOffAvailability" value="1" {{ old('dropOffAvailability') ? 'checked' : '' }}>
                                <label class="form-check-label" for="dropOffAvailability">
                                    Drop-off Available
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Create District
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function loadCreateZones(cityId) {
        const zoneSelect = document.getElementById('zone_id');
        
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
                    zoneSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading zones:', error);
                zoneSelect.innerHTML = '<option value="">Error loading zones</option>';
            });
    }
</script>
