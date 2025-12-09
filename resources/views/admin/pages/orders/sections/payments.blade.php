<div class="mb-3 card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h6 class="mb-0 card-title">
            <i class="ti ti-credit-card me-2"></i>
            Payments
        </h6>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="ti ti-plus me-1"></i>
            Add Payment
        </button>
    </div>
    <div class="card-body">
        @if($order->payments->isEmpty())
            <p class="mb-0 text-muted">No payments recorded yet.</p>
        @else
            <div class="table-responsive">
                <table class="table mb-0 table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Rest</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->payments as $payment)
                            <tr>
                                <td>
                                    <small>{{ $payment->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    {{ $payment->paymentMethod->name ?? 'N/A' }}
                                </td>
                                <td>{{ number_format($payment->amount, 2) }} EGP</td>
                                <td><strong class="text-success">{{ number_format($payment->paid, 2) }} EGP</strong></td>
                                <td>
                                    @if($payment->rest > 0)
                                        <span class="text-danger">{{ number_format($payment->rest, 2) }} EGP</span>
                                    @else
                                        <span class="text-muted">0.00 EGP</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->is_done)
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($payment->payment_status === 'pending_verification')
                                        <span class="badge bg-info">Pending Verification</span>
                                    @else
                                        <span class="badge bg-warning">Partial</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#paymentDetailsModal{{ $payment->id }}">
                                        <i class="ti ti-eye me-1"></i>
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total Paid:</strong></td>
                            <td colspan="5">
                                <strong class="text-success">{{ number_format($order->payments->sum('paid'), 2) }} EGP</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Payment Details Modals --}}
@foreach($order->payments as $payment)
<div class="modal fade" id="paymentDetailsModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-credit-card me-2"></i>
                    Payment Details #{{ $payment->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3 fw-bold">Payment Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td class="text-muted">Payment Date:</td>
                                <td class="fw-bold">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Payment Method:</td>
                                <td class="fw-bold">{{ $payment->paymentMethod->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Transaction ID:</td>
                                <td class="fw-bold">{{ $payment->transaction_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Amount:</td>
                                <td class="fw-bold">{{ number_format($payment->amount, 2) }} EGP</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Paid:</td>
                                <td class="fw-bold text-success">{{ number_format($payment->paid, 2) }} EGP</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Rest:</td>
                                <td class="fw-bold {{ $payment->rest > 0 ? 'text-danger' : 'text-muted' }}">
                                    {{ number_format($payment->rest, 2) }} EGP
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status:</td>
                                <td>
                                    @if($payment->is_done)
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($payment->payment_status === 'pending_verification')
                                        <span class="badge bg-info">Pending Verification</span>
                                    @else
                                        <span class="badge bg-warning">Partial</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-3 fw-bold">Payment Receipt</h6>
                        @php
                            $receipt = $payment->getFirstMediaUrl('payment_receipts');
                        @endphp

                        @if($receipt)
                            <div class="text-center">
                                <img src="{{ $receipt }}" alt="Payment Receipt" class="rounded border img-fluid" style="max-height: 400px;">
                                <div class="mt-3">
                                    <a href="{{ $receipt }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-download me-1"></i>
                                        Download Receipt
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="ti ti-alert-triangle me-2"></i>
                                No receipt uploaded for this payment.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                @if($payment->payment_status === 'pending_verification' && !$payment->is_done)
                    <form action="{{ route('admin.orders.payments.approve', $payment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this payment?')">
                            <i class="ti ti-check me-1"></i>
                            Approve Payment
                        </button>
                    </form>

                    <form action="{{ route('admin.orders.payments.reject', $payment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this payment?')">
                            <i class="ti ti-x me-1"></i>
                            Reject Payment
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
