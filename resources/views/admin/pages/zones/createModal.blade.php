<div class="modal fade" id="createZoneModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.zones.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-map-pin me-2"></i>Add New Zone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city_id" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
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

                        <div class="col-md-6 mb-3">
                            <label for="zoneId" class="form-label">Zone ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('zoneId') is-invalid @enderror" id="zoneId" name="zoneId" required value="{{ old('zoneId') }}" placeholder="e.g., Z001">
                            @error('zoneId')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="zoneName" class="form-label">Zone Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('zoneName') is-invalid @enderror" id="zoneName" name="zoneName" required value="{{ old('zoneName') }}" placeholder="e.g., Nasr City">
                            @error('zoneName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="zoneOtherName" class="form-label">Zone Other Name</label>
                            <input type="text" class="form-control @error('zoneOtherName') is-invalid @enderror" id="zoneOtherName" name="zoneOtherName" value="{{ old('zoneOtherName') }}" placeholder="Alternative name">
                            @error('zoneOtherName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
                        <i class="ti ti-check me-1"></i>Create Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
