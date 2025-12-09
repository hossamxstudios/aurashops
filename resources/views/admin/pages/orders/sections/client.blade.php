@if($order->client)
    <div class="card mb-3">
        <div class="card-header bg-light">
            <h6 class="card-title mb-0">
                <i class="ti ti-user me-2"></i>
                Client Information
            </h6>
        </div>
        <div class="card-body">
            <div class="mb-2">
                <strong>{{ $order->client->full_name }}</strong>
            </div>
            @if($order->client->phone)
                <div class="mb-2">
                    <i class="ti ti-phone me-1 text-muted"></i>
                    <a href="tel:{{ $order->client->phone }}">{{ $order->client->phone }}</a>
                </div>
            @endif
            @if($order->client->email)
                <div class="mb-2">
                    <i class="ti ti-mail me-1 text-muted"></i>
                    <a href="mailto:{{ $order->client->email }}">{{ $order->client->email }}</a>
                </div>
            @endif
            <div class="mt-3">
                <a href="{{ route('admin.clients.profile', $order->client->id) }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="ti ti-external-link me-1"></i>
                    View Profile
                </a>
            </div>
        </div>
    </div>
@endif
