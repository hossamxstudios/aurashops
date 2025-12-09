<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Shipment Details</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="py-1 pt-4 row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('admin.shipments.index') }}" class="btn btn-light btn-sm">
                                <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back to Shipments
                            </a>
                        </div>
                        <div class="col-auto">
                            <h3 class="fw-bold mb-0">
                                Shipment Details #{{ $shipment->id }}
                            </h3>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTrackingEventModal">
                                <i data-lucide="plus" class="icon-sm me-1"></i> Add Tracking Event
                            </button>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Shipment Information -->
                    <div class="row mt-3">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="package" class="icon-sm me-2"></i>Shipment Information
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Order ID</label>
                                            <div class="fw-bold">
                                                @if($shipment->order)
                                                    <a href="#" class="text-primary">#{{ $shipment->order->id }}</a>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Tracking Number</label>
                                            <div class="fw-bold">
                                                @if($shipment->tracking_number)
                                                    <code>{{ $shipment->tracking_number }}</code>
                                                @else
                                                    <span class="text-muted">Not assigned</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Status</label>
                                            <div>
                                                <span class="badge bg-{{ $shipment->status_badge_color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Shipper</label>
                                            <div class="fw-bold">
                                                @if($shipment->shipper)
                                                    {{ $shipment->shipper->name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Pickup Location</label>
                                            <div>
                                                @if($shipment->pickupLocation)
                                                    <strong>{{ ucfirst($shipment->pickupLocation->type) }}</strong>
                                                    <br><small class="text-muted">{{ $shipment->pickupLocation->full_address }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Delivery Address</label>
                                            <div>
                                                @if($shipment->address)
                                                    <small>{{ $shipment->address->full_address ?? '-' }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Estimated Delivery</label>
                                            <div class="fw-bold">
                                                @if($shipment->estimated_delivery_at)
                                                    {{ $shipment->estimated_delivery_at->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Delivered At</label>
                                            <div class="fw-bold">
                                                @if($shipment->delivered_at)
                                                    {{ $shipment->delivered_at->format('M d, Y H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Details -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="dollar-sign" class="icon-sm me-2"></i>Financial Details
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="text-muted small">COD Amount</label>
                                            <div class="fw-bold">
                                                {{ $shipment->cod_amount ? number_format($shipment->cod_amount, 2) : '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="text-muted small">COD Collected</label>
                                            <div class="fw-bold">
                                                @if($shipment->cod_collected)
                                                    <span class="text-success">{{ number_format($shipment->cod_collected, 2) }}</span>
                                                    @if($shipment->cod_collected_at)
                                                        <br><small class="text-muted">{{ $shipment->cod_collected_at->format('M d, Y') }}</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="text-muted small">Shipping Fee</label>
                                            <div class="fw-bold">
                                                {{ $shipment->shipping_fee ? number_format($shipment->shipping_fee, 2) : '-' }}
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="text-muted small">COD Fee</label>
                                            <div class="fw-bold">
                                                {{ $shipment->cod_fee ? number_format($shipment->cod_fee, 2) : '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            @if($shipment->client_notes || $shipment->carrier_notes || $shipment->failed_reason)
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="message-square" class="icon-sm me-2"></i>Notes & Details
                                    </h5>
                                    @if($shipment->client_notes)
                                    <div class="mb-3">
                                        <label class="text-muted small">Client Notes</label>
                                        <div class="p-2 bg-light rounded">{{ $shipment->client_notes }}</div>
                                    </div>
                                    @endif
                                    @if($shipment->carrier_notes)
                                    <div class="mb-3">
                                        <label class="text-muted small">Carrier Notes</label>
                                        <div class="p-2 bg-light rounded">{{ $shipment->carrier_notes }}</div>
                                    </div>
                                    @endif
                                    @if($shipment->failed_reason)
                                    <div class="mb-0">
                                        <label class="text-muted small">Failed Reason</label>
                                        <div class="p-2 bg-danger bg-opacity-10 text-danger rounded">{{ $shipment->failed_reason }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Tracking Events Timeline -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="map-pin" class="icon-sm me-2"></i>Tracking Events
                                        <span class="badge bg-primary ms-2">{{ $shipment->trackingEvents->count() }}</span>
                                    </h5>
                                    
                                    @forelse($shipment->trackingEvents as $event)
                                        <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                    <i data-lucide="map-pin" class="icon-sm text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        @if($event->status)
                                                            <span class="badge bg-info mb-1">{{ ucfirst($event->status) }}</span>
                                                        @endif
                                                        @if($event->carrier_status_label)
                                                            <div class="fw-bold">{{ $event->carrier_status_label }}</div>
                                                        @endif
                                                        @if($event->carrier_status_code)
                                                            <small class="text-muted">Code: {{ $event->carrier_status_code }}</small>
                                                        @endif
                                                        @if($event->location)
                                                            <div class="mt-1">
                                                                <i data-lucide="map-pin" class="icon-sm"></i>
                                                                <small class="text-muted">{{ $event->location }}</small>
                                                            </div>
                                                        @endif
                                                        @if($event->location_details)
                                                            <div><small class="text-muted">{{ $event->location_details }}</small></div>
                                                        @endif
                                                        @if($event->details)
                                                            <div class="mt-1 small">{{ $event->details }}</div>
                                                        @endif
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i data-lucide="clock" class="icon-sm"></i>
                                                                {{ $event->created_at->format('M d, Y H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-sm btn-danger" onclick="deleteEvent({{ $event->id }})" title="Delete">
                                                            <i data-lucide="trash-2" class="icon-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4">
                                            <i data-lucide="inbox" class="icon-lg text-muted mb-2"></i>
                                            <p class="text-muted mb-0">No tracking events yet</p>
                                            <small class="text-muted">Add tracking events to monitor shipment progress</small>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Tracking Event Modal -->
                    @include('admin.pages.shipments.addTrackingEventModal')

                    <!-- Delete Event Form (Hidden) -->
                    <form id="deleteEventForm" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    
    <script>
        // Re-initialize Lucide icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this tracking event?')) {
                const form = document.getElementById('deleteEventForm');
                form.action = `/admin/shipments/{{ $shipment->id }}/tracking-events/${eventId}`;
                form.submit();
            }
        }
    </script>
</body>
</html>
