<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.shipments.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Shipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Order <span class="text-danger">*</span></label>
                            <select class="form-select" name="order_id" id="create_order_id" required>
                                <option value="">Select Order</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">Order #{{ $order->id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Shipper</label>
                            <select class="form-select" name="shipper_id">
                                <option value="">Select Shipper</option>
                                @foreach($shippers as $shipper)
                                    <option value="{{ $shipper->id }}">{{ $shipper->carrier_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Pickup Location</label>
                            <select class="form-select" name="pickup_location_id">
                                <option value="">Select Pickup Location</option>
                                @foreach($pickupLocations as $location)
                                    <option value="{{ $location->id }}">{{ $location->type }} - {{ $location->full_address }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="picked_up">Picked Up</option>
                                <option value="out_for_delivery">Out for Delivery</option>
                                <option value="delivered">Delivered</option>
                                <option value="failed">Failed</option>
                                <option value="returned">Returned</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" name="tracking_number" placeholder="e.g., TRK123456789">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Estimated Delivery</label>
                            <input type="date" class="form-control" name="estimated_delivery_at">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Financial Details</h6>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">COD Amount</label>
                            <input type="number" step="0.01" class="form-control" name="cod_amount" placeholder="0.00">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Shipping Fee</label>
                            <input type="number" step="0.01" class="form-control" name="shipping_fee" placeholder="0.00">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">COD Fee</label>
                            <input type="number" step="0.01" class="form-control" name="cod_fee" placeholder="0.00">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Notes</h6>

                    <div class="mb-3">
                        <label class="form-label">Client Notes</label>
                        <textarea class="form-control" name="client_notes" rows="2" placeholder="Notes for client..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carrier Notes</label>
                        <textarea class="form-control" name="carrier_notes" rows="2" placeholder="Internal notes for carrier..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for searchable order dropdown
    let createOrderChoices;

    document.addEventListener('DOMContentLoaded', function() {
        createOrderChoices = new Choices('#create_order_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search orders...',
            itemSelectText: '',
            shouldSort: false
        });
    });
</script>
