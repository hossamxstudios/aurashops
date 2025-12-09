<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.shipping-rates.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Shipping Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Shipper <span class="text-danger">*</span></label>
                        <select class="form-select" name="shipper_id" required>
                            <option value="">Select Shipper</option>
                            @foreach($shippers as $shipper)
                                <option value="{{ $shipper->id }}">{{ $shipper->carrier_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <select class="form-select" name="city_id" required>
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->cityName }} ({{ $city->cityCode }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipping Rate <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="rate" step="0.01" min="0" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">COD Fee <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" name="cod_fee" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">COD Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="cod_type" required>
                            <option value="">Select Type</option>
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="create_is_free_shipping" name="is_free_shipping" value="1">
                            <label class="form-check-label" for="create_is_free_shipping">
                                Enable Free Shipping
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="create_threshold_group" style="display: none;">
                        <label class="form-label">Free Shipping Threshold</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="free_shipping_threshold" step="0.01" min="0" value="0">
                        </div>
                        <small class="text-muted">Orders above this amount will have free shipping</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle free shipping threshold field
    document.getElementById('create_is_free_shipping').addEventListener('change', function() {
        const thresholdGroup = document.getElementById('create_threshold_group');
        if (this.checked) {
            thresholdGroup.style.display = 'block';
        } else {
            thresholdGroup.style.display = 'none';
        }
    });
</script>
