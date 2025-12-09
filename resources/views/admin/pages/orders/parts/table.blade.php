<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($orders->isEmpty())
                    <div class="text-center py-5">
                        <i class="ti ti-shopping-cart-off" style="font-size: 4rem; opacity: 0.3;"></i>
                        <h5 class="mt-3">No Orders Found</h5>
                        <p class="text-muted">There are no orders matching your criteria.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Client</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>#{{ $order->id }}</strong>
                                        </td>
                                        <td>
                                            @if($order->client)
                                                <a href="{{ route('admin.clients.profile', $order->client->id) }}" class="text-decoration-none">
                                                    {{ $order->client->full_name }}
                                                </a>
                                                <br>
                                                <small class="text-muted">{{ $order->client->phone }}</small>
                                            @else
                                                <span class="text-muted">Guest</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $order->items->count() }} {{ $order->items->count() === 1 ? 'Item' : 'Items' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ number_format($order->total_amount, 2) }} EGP</strong>
                                        </td>
                                        <td>
                                            @if($order->orderStatus)
                                                <span class="badge" style="background-color: {{ $order->orderStatus->color }};">
                                                    {{ $order->orderStatus->name }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->is_paid)
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i>
                                                    Paid
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="ti ti-x me-1"></i>
                                                    Unpaid
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->source === 'POS')
                                                <span class="badge bg-info">
                                                    <i class="ti ti-device-desktop me-1"></i>
                                                    POS
                                                </span>
                                            @else
                                                <span class="badge bg-primary">
                                                    <i class="ti ti-world me-1"></i>
                                                    Online
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $order->created_at->format('M d, Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
