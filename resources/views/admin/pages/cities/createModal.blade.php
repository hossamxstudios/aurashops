<div class="modal fade" id="createCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-building-community me-2"></i>Add New City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cityId" class="form-label">City ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cityId') is-invalid @enderror" id="cityId" name="cityId" required value="{{ old('cityId') }}" placeholder="e.g., CAI">
                        @error('cityId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cityName" class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cityName') is-invalid @enderror" id="cityName" name="cityName" required value="{{ old('cityName') }}" placeholder="e.g., Cairo">
                        @error('cityName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cityOtherName" class="form-label">City Other Name</label>
                        <input type="text" class="form-control @error('cityOtherName') is-invalid @enderror" id="cityOtherName" name="cityOtherName" value="{{ old('cityOtherName') }}" placeholder="Alternative name">
                        @error('cityOtherName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cityCode" class="form-label">City Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cityCode') is-invalid @enderror" id="cityCode" name="cityCode" required value="{{ old('cityCode') }}" placeholder="e.g., 02">
                        @error('cityCode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Create City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
