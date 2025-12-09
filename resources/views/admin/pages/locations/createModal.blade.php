<div class="modal fade" id="createLocationModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.locations.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="map-pin" class="me-2"></i>Add New Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- City Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i data-lucide="building-2" class="me-2"></i>City Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="cityId" class="form-label">City ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('cityId') is-invalid @enderror" id="cityId" name="cityId" required value="{{ old('cityId') }}" placeholder="CAI">
                                    @error('cityId')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="cityName" class="form-label">City Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('cityName') is-invalid @enderror" id="cityName" name="cityName" required value="{{ old('cityName') }}" placeholder="Cairo">
                                    @error('cityName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="cityOtherName" class="form-label">Other Name</label>
                                    <input type="text" class="form-control @error('cityOtherName') is-invalid @enderror" id="cityOtherName" name="cityOtherName" value="{{ old('cityOtherName') }}" placeholder="القاهرة">
                                    @error('cityOtherName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="cityCode" class="form-label">City Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('cityCode') is-invalid @enderror" id="cityCode" name="cityCode" required value="{{ old('cityCode') }}" placeholder="EG-01">
                                    @error('cityCode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Zones & Districts -->
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i data-lucide="map" class="me-2"></i>Zones & Districts</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addZone()">
                                <i data-lucide="plus" class="me-1"></i>Add Zone
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="zonesContainer"></div>
                            <p class="text-muted text-center" id="noZonesMessage">Click "Add Zone" to start adding zones and districts</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check" class="me-1"></i>Create Location
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let zoneIndex = 0;

function addZone() {
    const container = document.getElementById('zonesContainer');
    document.getElementById('noZonesMessage').style.display = 'none';
    
    const zoneHtml = `
        <div class="zone-item border rounded p-3 mb-3" data-zone-index="${zoneIndex}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0"><i data-lucide="map-pin"></i> Zone #${zoneIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeZone(${zoneIndex})">
                    <i data-lucide="x"></i> Remove Zone
                </button>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Zone ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="zones[${zoneIndex}][zoneId]" required placeholder="Z001">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Zone Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="zones[${zoneIndex}][zoneName]" required placeholder="Downtown">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Other Name</label>
                    <input type="text" class="form-control" name="zones[${zoneIndex}][zoneOtherName]" placeholder="وسط البلد">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Options</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="zones[${zoneIndex}][pickupAvailability]" value="1" checked>
                        <label class="form-check-label">Pickup</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="zones[${zoneIndex}][dropOffAvailability]" value="1" checked>
                        <label class="form-check-label">Drop-off</label>
                    </div>
                </div>
            </div>
            
            <div class="border-top pt-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong><i data-lucide="map"></i> Districts</strong>
                    <button type="button" class="btn btn-sm btn-success" onclick="addDistrict(${zoneIndex})">
                        <i data-lucide="plus"></i> Add District
                    </button>
                </div>
                <div id="districtsContainer${zoneIndex}"></div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', zoneHtml);
    zoneIndex++;
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function removeZone(index) {
    const zone = document.querySelector(`[data-zone-index="${index}"]`);
    if (zone) {
        zone.remove();
    }
    
    // Show message if no zones
    const container = document.getElementById('zonesContainer');
    if (container.children.length === 0) {
        document.getElementById('noZonesMessage').style.display = 'block';
    }
}

let districtIndexes = {};

function addDistrict(zoneIdx) {
    if (!districtIndexes[zoneIdx]) {
        districtIndexes[zoneIdx] = 0;
    }
    
    const container = document.getElementById(`districtsContainer${zoneIdx}`);
    const districtIdx = districtIndexes[zoneIdx];
    
    const districtHtml = `
        <div class="row mb-2 district-item" data-district-index="${districtIdx}">
            <div class="col-md-2">
                <input type="text" class="form-control form-control-sm" name="zones[${zoneIdx}][districts][${districtIdx}][districtId]" required placeholder="D001">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" name="zones[${zoneIdx}][districts][${districtIdx}][districtName]" required placeholder="District Name">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" name="zones[${zoneIdx}][districts][${districtIdx}][districtOtherName]" placeholder="Other Name">
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="zones[${zoneIdx}][districts][${districtIdx}][pickupAvailability]" value="1" checked>
                        <label class="form-check-label small">Pickup</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="zones[${zoneIdx}][districts][${districtIdx}][dropOffAvailability]" value="1" checked>
                        <label class="form-check-label small">Drop-off</label>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.district-item').remove()">
                    <i data-lucide="x"></i>
                </button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', districtHtml);
    districtIndexes[zoneIdx]++;
    
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}
</script>
