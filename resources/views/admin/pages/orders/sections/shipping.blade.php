<div class="mb-3 card">
    <div class="card-header bg-light">
        <h6 class="mb-0 card-title">
            <i class="ti ti-truck me-2"></i>
            Shipping Information
        </h6>
    </div>
    <div class="card-body">
        @if(!$order->shipment)
            <div class="py-4 text-center">
                <i class="ti ti-truck-off" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mt-2 mb-0 text-muted">No shipment created yet</p>
                <small class="text-muted">Shipment will be created when order is processed</small>
            </div>
        @else
            @php $shipment = $order->shipment; @endphp

            <!-- Shipment Status -->
            <div class="p-3 mb-3 rounded bg-light">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <small class="text-muted fw-semibold">
                        <i class="ti ti-info-circle me-1"></i>
                        Shipment Status
                    </small>
                    <span class="badge bg-{{ $shipment->statusBadgeColor }}">
                        {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                    </span>
                </div>

                @if($shipment->tracking_number)
                    <div class="mt-2">
                        <small class="text-muted d-block">Tracking Number</small>
                        <strong class="text-primary">{{ $shipment->tracking_number }}</strong>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Shipper Information -->
                    @if($shipment->shipper)
                        <div class="mb-3">
                            <small class="mb-1 text-muted d-block">
                                <i class="ti ti-building me-1"></i>
                                Shipping Company
                            </small>
                            <strong>{{ $shipment->shipper->name }}</strong>
                            @if($shipment->shipper->phone)
                                <br>
                                <small class="text-muted">{{ $shipment->shipper->phone }}</small>
                            @endif
                        </div>
                    @endif

                    <!-- Shipping Fees -->
                    @if($shipment->shipping_fee)
                        <div class="mb-3">
                            <small class="mb-1 text-muted d-block">
                                <i class="ti ti-coin me-1"></i>
                                Shipping Fee
                            </small>
                            <strong class="text-primary fs-5">{{ number_format($shipment->shipping_fee, 2) }} EGP</strong>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <!-- Estimated Delivery -->
                    @if($shipment->estimated_delivery_at)
                        <div class="mb-3">
                            <small class="mb-1 text-muted d-block">
                                <i class="ti ti-calendar-event me-1"></i>
                                Estimated Delivery
                            </small>
                            <strong>{{ $shipment->estimated_delivery_at->format('M d, Y') }}</strong>
                        </div>
                    @endif

                    <!-- Actual Delivery -->
                    @if($shipment->delivered_at)
                        <div class="mb-3">
                            <small class="mb-1 text-muted d-block">
                                <i class="ti ti-check-circle me-1 text-success"></i>
                                Delivered At
                            </small>
                            <strong class="text-success">{{ $shipment->delivered_at->format('M d, Y - h:i A') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Shipment Timeline -->
            <div class="mb-3">
                <small class="mb-2 text-muted d-block fw-semibold">
                    <i class="ti ti-timeline me-1"></i>
                    Shipment Timeline
                </small>
                <div class="table-responsive">
                    <table class="table mb-0 table-sm table-borderless">
                        <tbody>
                            @if($shipment->picked_up_at)
                                <tr>
                                    <td width="30%" class="text-muted"><i class="ti ti-package-import me-1"></i> Picked Up</td>
                                    <td><strong>{{ $shipment->picked_up_at->format('M d, Y - h:i A') }}</strong></td>
                                </tr>
                            @endif
                            @if($shipment->out_for_delivery_at)
                                <tr>
                                    <td class="text-muted"><i class="ti ti-truck-delivery me-1"></i> Out for Delivery</td>
                                    <td><strong>{{ $shipment->out_for_delivery_at->format('M d, Y - h:i A') }}</strong></td>
                                </tr>
                            @endif
                            @if($shipment->delivered_at)
                                <tr>
                                    <td class="text-muted"><i class="ti ti-circle-check me-1 text-success"></i> Delivered</td>
                                    <td><strong class="text-success">{{ $shipment->delivered_at->format('M d, Y - h:i A') }}</strong></td>
                                </tr>
                            @endif
                            @if($shipment->failed_at)
                                <tr>
                                    <td class="text-muted"><i class="ti ti-alert-circle me-1 text-danger"></i> Failed</td>
                                    <td>
                                        <strong class="text-danger">{{ $shipment->failed_at->format('M d, Y - h:i A') }}</strong>
                                        @if($shipment->failed_reason)
                                            <br><small class="text-danger">{{ $shipment->failed_reason }}</small>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @if($shipment->returned_at)
                                <tr>
                                    <td class="text-muted"><i class="ti ti-package-export me-1 text-warning"></i> Returned</td>
                                    <td><strong class="text-warning">{{ $shipment->returned_at->format('M d, Y - h:i A') }}</strong></td>
                                </tr>
                            @endif
                            @if($shipment->cancelled_at)
                                <tr>
                                    <td class="text-muted"><i class="ti ti-ban me-1 text-dark"></i> Cancelled</td>
                                    <td><strong class="text-dark">{{ $shipment->cancelled_at->format('M d, Y - h:i A') }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tracking Events (from Carrier) -->
            @if($shipment->trackingEvents && $shipment->trackingEvents->isNotEmpty())
                <div class="mb-3">
                    <small class="mb-2 text-muted d-block fw-semibold">
                        <i class="ti ti-route me-1"></i>
                        Carrier Tracking Events
                    </small>
                    <div class="alert alert-light mb-0">
                        @foreach($shipment->trackingEvents as $event)
                            <div class="d-flex align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="me-3">
                                    <i class="ti ti-circle-dot text-primary" style="font-size: 1.2rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            @if($event->carrier_status_label)
                                                <strong>{{ $event->carrier_status_label }}</strong>
                                            @elseif($event->status)
                                                <strong>{{ ucfirst($event->status) }}</strong>
                                            @endif
                                            @if($event->carrier_status_code)
                                                <span class="badge bg-secondary ms-2">{{ $event->carrier_status_code }}</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $event->created_at->format('M d, Y - h:i A') }}</small>
                                    </div>
                                    
                                    @if($event->location)
                                        <div class="text-muted mb-1">
                                            <i class="ti ti-map-pin me-1"></i>
                                            <small>{{ $event->location }}</small>
                                            @if($event->location_details)
                                                <small class="text-muted">- {{ $event->location_details }}</small>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @if($event->details)
                                        <div class="text-muted">
                                            <small>{{ $event->details }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- COD Information -->
            @if($shipment->cod_amount > 0)
                <div class="mb-3">
                    <div class="mb-0 alert alert-warning">
                        <div class="mb-2 d-flex align-items-center">
                            <i class="ti ti-cash me-2" style="font-size: 1.5rem;"></i>
                            <div class="flex-grow-1">
                                <strong>Cash on Delivery (COD)</strong>
                                <small class="d-block text-muted">Payment collected upon delivery</small>
                            </div>
                        </div>

                        <div class="mt-2 row">
                            <div class="col-4">
                                <small class="text-muted d-block">COD Amount</small>
                                <strong>{{ number_format($shipment->cod_amount, 2) }} EGP</strong>
                            </div>
                            @if($shipment->cod_fee)
                                <div class="col-4">
                                    <small class="text-muted d-block">COD Fee</small>
                                    <strong class="text-danger">{{ number_format($shipment->cod_fee, 2) }} EGP</strong>
                                </div>
                            @endif
                            @if($shipment->cod_collected)
                                <div class="col-4">
                                    <small class="text-muted d-block">Collected</small>
                                    <strong class="text-success">{{ number_format($shipment->cod_collected, 2) }} EGP</strong>
                                    @if($shipment->cod_collected_at)
                                        <br><small class="text-muted">{{ $shipment->cod_collected_at->format('M d, Y') }}</small>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Shipping Address -->
            @if($shipment->address)
                <div class="mb-3">
                    <small class="mb-2 text-muted d-block fw-semibold">
                        <i class="ti ti-map-pin me-1"></i>
                        Shipping Address
                    </small>
                    <div class="p-2 rounded bg-light">
                        @if($shipment->address->street)
                            <div class="mb-1">
                                <i class="ti ti-building me-1 text-muted"></i>
                                {{ $shipment->address->street }}
                            </div>
                        @endif
                        @if($shipment->address->district)
                            <div class="mb-1">
                                <i class="ti ti-map-2 me-1 text-muted"></i>
                                {{ $shipment->address->district->name }}
                                @if($shipment->address->zone)
                                    , {{ $shipment->address->zone->name }}
                                @endif
                                @if($shipment->address->city)
                                    , {{ $shipment->address->city->name }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Pickup Location -->
            @if($shipment->pickupLocation)
                <div class="mb-3">
                    <div class="mb-0 alert alert-info">
                        <div class="mb-1">
                            <i class="ti ti-map-pin me-1"></i>
                            <strong>Pickup from: {{ $shipment->pickupLocation->name }}</strong>
                        </div>
                        @if($shipment->pickupLocation->address)
                            <small class="d-block text-muted">
                                <i class="ti ti-location me-1"></i>
                                {{ $shipment->pickupLocation->address }}
                            </small>
                        @endif
                        @if($shipment->pickupLocation->phone)
                            <small class="mt-1 d-block text-muted">
                                <i class="ti ti-phone me-1"></i>
                                {{ $shipment->pickupLocation->phone }}
                            </small>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($shipment->client_notes || $shipment->carrier_notes)
                <div class="mb-0">
                    <small class="mb-2 text-muted d-block fw-semibold">
                        <i class="ti ti-notes me-1"></i>
                        Shipment Notes
                    </small>
                    @if($shipment->client_notes)
                        <div class="p-2 mb-2 rounded bg-light">
                            <small class="text-muted d-block">Client Notes:</small>
                            <div>{{ $shipment->client_notes }}</div>
                        </div>
                    @endif
                    @if($shipment->carrier_notes)
                        <div class="p-2 rounded bg-light">
                            <small class="text-muted d-block">Carrier Notes:</small>
                            <div>{{ $shipment->carrier_notes }}</div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Technical Information (Collapsible) -->
            @if($shipment->carrier_metadata || $shipment->carrier_response || $shipment->webhook_data)
                <div class="mb-0">
                    <div class="accordion" id="technicalInfoAccordion">
                        <div class="accordion-item border">
                            <h2 class="accordion-header" id="headingTechnical">
                                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTechnical" aria-expanded="false" aria-controls="collapseTechnical">
                                    <i class="ti ti-code me-2"></i>
                                    <small class="fw-semibold">Technical Information (Debug)</small>
                                </button>
                            </h2>
                            <div id="collapseTechnical" class="accordion-collapse collapse" aria-labelledby="headingTechnical" data-bs-parent="#technicalInfoAccordion">
                                <div class="accordion-body">
                                    @if($shipment->carrier_metadata)
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1 fw-semibold">Carrier Metadata:</small>
                                            <pre class="bg-dark text-light p-2 rounded" style="font-size: 11px; max-height: 200px; overflow-y: auto;"><code>{{ $shipment->carrier_metadata }}</code></pre>
                                        </div>
                                    @endif

                                    @if($shipment->carrier_response)
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1 fw-semibold">Carrier API Response:</small>
                                            <pre class="bg-dark text-light p-2 rounded" style="font-size: 11px; max-height: 200px; overflow-y: auto;"><code>{{ $shipment->carrier_response }}</code></pre>
                                        </div>
                                    @endif

                                    @if($shipment->webhook_data)
                                        <div class="mb-0">
                                            <small class="text-muted d-block mb-1 fw-semibold">Webhook Data:</small>
                                            <pre class="bg-dark text-light p-2 rounded" style="font-size: 11px; max-height: 200px; overflow-y: auto;"><code>{{ $shipment->webhook_data }}</code></pre>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
