@if($order->address)
    <div class="card mb-3">
        <div class="card-header bg-light">
            <h6 class="card-title mb-0">
                <i class="ti ti-map-pin me-2"></i>
                Shipping Address
            </h6>
        </div>
        <div class="card-body">
            @if($order->address->label)
                <div class="mb-2">
                    <span class="badge bg-secondary">{{ $order->address->label }}</span>
                </div>
            @endif
            
            @if($order->address->street)
                <div class="mb-1">
                    <i class="ti ti-building me-1 text-muted"></i>
                    {{ $order->address->street }}
                </div>
            @endif

            @if($order->address->building_no)
                <div class="mb-1">
                    <i class="ti ti-home me-1 text-muted"></i>
                    Building: {{ $order->address->building_no }}
                    @if($order->address->floor_no)
                        , Floor: {{ $order->address->floor_no }}
                    @endif
                    @if($order->address->apartment_no)
                        , Apt: {{ $order->address->apartment_no }}
                    @endif
                </div>
            @endif

            @if($order->address->district)
                <div class="mb-1">
                    <i class="ti ti-map-2 me-1 text-muted"></i>
                    {{ $order->address->district->name }}
                </div>
            @endif

            @if($order->address->zone)
                <div class="mb-1">
                    <i class="ti ti-map me-1 text-muted"></i>
                    {{ $order->address->zone->name }}
                </div>
            @endif

            @if($order->address->city)
                <div class="mb-1">
                    <i class="ti ti-building-community me-1 text-muted"></i>
                    {{ $order->address->city->name }}
                </div>
            @endif

            @if($order->address->landmarks)
                <div class="mt-2 p-2 bg-light rounded">
                    <small class="text-muted">Landmarks:</small>
                    <small class="d-block">{{ $order->address->landmarks }}</small>
                </div>
            @endif
        </div>
    </div>
@endif
