<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Shipment
        </span>
        <h3 class="fw-bold">
            Shipments
        </h3>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Search Filter -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                <input type="text" id="searchShipments" class="form-control" placeholder="Search by tracking number or order ID...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Tracking #</th>
                                <th>Shipper</th>
                                <th>Status</th>
                                <th>COD Amount</th>
                                <th>Shipping Fee</th>
                                <th>Estimated Delivery</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="shipmentsTableBody">
                            @forelse($shipments as $shipment)
                                <tr>
                                    <td>{{ $shipment->id }}</td>
                                    <td>
                                        @if($shipment->order)
                                            <a href="#" class="fw-bold text-primary">#{{ $shipment->order?->id }}</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($shipment->tracking_number)
                                            <code class="small">{{ $shipment->tracking_number }}</code>
                                        @else
                                            <span class="text-muted small">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($shipment->shipper)
                                            <span>{{ $shipment->shipper?->carrier_name }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $shipment->status_badge_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($shipment->cod_amount)
                                            <span class="fw-bold">{{ number_format($shipment->cod_amount, 2) }}</span>
                                            @if($shipment->cod_collected)
                                                <br><small class="text-success"><i data-lucide="check-circle" class="icon-sm"></i> Collected</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($shipment->shipping_fee)
                                            <span>{{ number_format($shipment->shipping_fee, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($shipment->estimated_delivery_at)
                                            <small>{{ $shipment->estimated_delivery_at->format('M d, Y') }}</small>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                            <i data-lucide="eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-light" onclick="editShipment({{ $shipment->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteShipment({{ $shipment->id }}, '{{ $shipment->tracking_number ?? 'Shipment #'.$shipment->id }}')" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No shipments found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $shipments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.shipments.createModal')
@include('admin.pages.shipments.editModal')
@include('admin.pages.shipments.deleteModal')

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter shipments table
    document.getElementById('searchShipments').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('shipmentsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const orderId = row.cells[1]?.textContent.toLowerCase() || '';
            const trackingNumber = row.cells[2]?.textContent.toLowerCase() || '';

            if (orderId.includes(searchTerm) || trackingNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
