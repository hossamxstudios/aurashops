<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.orders.add-payment', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">
                        <i class="ti ti-cash me-2"></i>
                        Add Payment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method_id" class="form-select" required>
                            <option value="">Select Payment Method</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                        <input type="number" name="amount" class="form-control" step="0.01" min="0" value="{{ $order->total_amount }}" required>
                        <small class="text-muted">Order total: {{ number_format($order->total_amount, 2) }} EGP</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Paid Amount <span class="text-danger">*</span></label>
                        <input type="number" name="paid" class="form-control" step="0.01" min="0" value="{{ $order->total_amount }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Collection Fee</label>
                        <input type="number" name="collection_fee" class="form-control" step="0.01" min="0" value="0">
                        <small class="text-muted">Fee charged by payment gateway or service</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="Optional reference number">
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="ti ti-info-circle me-2"></i>
                        <small>Rest amount will be calculated automatically. If fully paid, order status will update.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>
                        Add Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
