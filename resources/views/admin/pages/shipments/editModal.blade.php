<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Shipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Order <span class="text-danger">*</span></label>
                            <select class="form-select" name="order_id" id="edit_order_id" required>
                                <option value="">Select Order</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">Order #{{ $order->id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipper</label>
                            <select class="form-select" name="shipper_id" id="edit_shipper_id">
                                <option value="">Select Shipper</option>
                                @foreach($shippers as $shipper)
                                    <option value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pickup Location</label>
                            <select class="form-select" name="pickup_location_id" id="edit_pickup_location_id">
                                <option value="">Select Pickup Location</option>
                                @foreach($pickupLocations as $location)
                                    <option value="{{ $location->id }}">{{ $location->type }} - {{ $location->full_address }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="status" id="edit_status" required>
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" name="tracking_number" id="edit_tracking_number" placeholder="e.g., TRK123456789">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estimated Delivery</label>
                            <input type="date" class="form-control" name="estimated_delivery_at" id="edit_estimated_delivery_at">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Financial Details</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">COD Amount</label>
                            <input type="number" step="0.01" class="form-control" name="cod_amount" id="edit_cod_amount" placeholder="0.00">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">COD Collected</label>
                            <input type="number" step="0.01" class="form-control" name="cod_collected" id="edit_cod_collected" placeholder="0.00">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">COD Fee</label>
                            <input type="number" step="0.01" class="form-control" name="cod_fee" id="edit_cod_fee" placeholder="0.00">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shipping Fee</label>
                            <input type="number" step="0.01" class="form-control" name="shipping_fee" id="edit_shipping_fee" placeholder="0.00">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Failed Reason</label>
                            <input type="text" class="form-control" name="failed_reason" id="edit_failed_reason" placeholder="Only if status is failed">
                        </div>
                    </div>

                    <h6 class="mt-2 mb-3">Notes</h6>

                    <div class="mb-3">
                        <label class="form-label">Client Notes</label>
                        <textarea class="form-control" name="client_notes" id="edit_client_notes" rows="2" placeholder="Notes for client..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carrier Notes</label>
                        <textarea class="form-control" name="carrier_notes" id="edit_carrier_notes" rows="2" placeholder="Internal notes for carrier..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize Choices.js for searchable order dropdown
    let editOrderChoices;
    
    document.addEventListener('DOMContentLoaded', function() {
        editOrderChoices = new Choices('#edit_order_id', {
            searchEnabled: true,
            searchPlaceholderValue: 'Search orders...',
            itemSelectText: '',
            shouldSort: false
        });
    });

    function editShipment(id) {
        fetch(`/admin/shipments/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/shipments/${id}`;
                
                // Set order using Choices.js
                editOrderChoices.setChoiceByValue(data.order_id ? data.order_id.toString() : '');
                
                document.getElementById('edit_shipper_id').value = data.shipper_id || '';
                document.getElementById('edit_pickup_location_id').value = data.pickup_location_id || '';
                document.getElementById('edit_status').value = data.status;
                document.getElementById('edit_tracking_number').value = data.tracking_number || '';
                document.getElementById('edit_estimated_delivery_at').value = data.estimated_delivery_at ? data.estimated_delivery_at.split('T')[0] : '';
                document.getElementById('edit_cod_amount').value = data.cod_amount || '';
                document.getElementById('edit_cod_collected').value = data.cod_collected || '';
                document.getElementById('edit_cod_fee').value = data.cod_fee || '';
                document.getElementById('edit_shipping_fee').value = data.shipping_fee || '';
                document.getElementById('edit_failed_reason').value = data.failed_reason || '';
                document.getElementById('edit_client_notes').value = data.client_notes || '';
                document.getElementById('edit_carrier_notes').value = data.carrier_notes || '';

                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load shipment details');
            });
    }
</script>
