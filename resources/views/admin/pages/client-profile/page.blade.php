<div class="pt-3 row">
    <!-- Client Information Card - Minimal Design -->
    <div class="col-12">
        <div class="card {{ $client->is_blocked ? 'border-danger' : '' }} shadow-sm">
            <div class="p-4 card-body">
                <div class="gap-4 d-flex align-items-start">
                    <!-- Profile Image -->
                    <div class="flex-shrink-0">
                        @if ($client->getMedia('profile')?->first()?->getUrl())
                            <img src="{{ $client->getMedia('profile')?->first()?->getUrl() }}" alt="avatar" class="rounded" width="100" height="100" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('admin/assets/images/users/user-1.jpg') }}" alt="avatar" class="rounded" width="100" height="100" style="object-fit: cover;">
                        @endif
                    </div>

                    <!-- Client Info -->
                    <div class="flex-grow-1">
                        <div class="mb-3 d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="mb-1">{{ $client->full_name }}</h3>
                                <div class="gap-2 d-flex align-items-center">
                                    <span class="text-muted fs-sm">{{ $client->email }}</span>
                                    @if($client->is_blocked)
                                        <span class="border-0 badge bg-danger-subtle text-danger">
                                            <i class="ti ti-ban fs-xs me-1"></i>Blocked
                                        </span>
                                    @else
                                        <span class="border-0 badge bg-success-subtle text-success">
                                            <i class="ti ti-check fs-xs me-1"></i>Active
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="gap-2 d-flex">
                                <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#editOffCanvas" title="Edit Profile">
                                    <i class="ti ti-edit"></i>
                                </button>
                                <button class="btn btn-{{ $client->is_blocked ? 'success' : 'warning' }}-subtle btn-sm text-{{ $client->is_blocked ? 'success' : 'warning' }}" data-bs-toggle="modal" data-bs-target="#blockModal" title="{{ $client->is_blocked ? 'Unblock' : 'Block' }} Client">
                                    <i class="ti ti-ban"></i>
                                </button>
                                <button class="btn btn-danger-subtle btn-sm text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete Client">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="gap-2 d-flex align-items-start">
                                            <i class="mt-1 ti ti-phone text-muted"></i>
                                            <div>
                                                <div class="mb-1 text-muted fs-xs">Phone</div>
                                                <div class="fw-medium">{{ $client->phone ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="gap-2 d-flex align-items-start">
                                            <i class="ti ti-gender-{{ $client->gender == 'Male' ? 'male' : 'female' }} text-muted mt-1"></i>
                                            <div>
                                                <div class="mb-1 text-muted fs-xs">Gender</div>
                                                <div>
                                                    @if($client->gender == 'Male')
                                                        <span class="border-0 fw-medium">Male</span>
                                                    @elseif($client->gender == 'Female')
                                                        <span class="border-0 fw-medium">Female</span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="gap-2 d-flex align-items-start">
                                            <i class="mt-1 ti ti-cake text-muted"></i>
                                            <div>
                                                <div class="mb-1 text-muted fs-xs">Birthdate</div>
                                                <div class="fw-medium">{{ $client->birthdate ? \Carbon\Carbon::parse($client->birthdate)->format('M d, Y') : 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="gap-2 d-flex align-items-start">
                                            <i class="mt-1 ti ti-calendar text-muted"></i>
                                            <div>
                                                <div class="mb-1 text-muted fs-xs">Member Since</div>
                                                <div class="fw-medium">{{ $client->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="gap-2 d-flex align-items-start">
                                            <i class="mt-1 ti ti-palette text-muted"></i>
                                            <div class="flex-grow-1">
                                                <div class="mb-1 text-muted fs-xs">Skin Tone</div>
                                                <div>
                                                    @if($client->skinTone)
                                                        <div class="gap-2 d-flex align-items-center">
                                                            @if($client->skinTone->getMedia('skin_tone_image')->first())
                                                                <img src="{{ $client->skinTone->getMedia('skin_tone_image')->first()->getUrl() }}" alt="{{ $client->skinTone->name }}" class="rounded" style="width: 24px; height: 24px; object-fit: cover;">
                                                            @endif
                                                            <span class="fw-medium">{{ $client->skinTone->name }}</span>
                                                            <button class="p-1 btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#skinProfileModal" style="width: 24px; height: 24px; line-height: 1;">
                                                                <i class="ti ti-edit" style="font-size: 12px;"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-primary-subtle btn-sm text-primary" data-bs-toggle="modal" data-bs-target="#skinProfileModal">
                                                            <i class="ti ti-plus fs-xs me-1"></i>Add
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="gap-2 d-flex align-items-start">
                                            <i class="mt-1 ti ti-droplet text-muted"></i>
                                            <div class="flex-grow-1">
                                                <div class="mb-1 text-muted fs-xs">Skin Type</div>
                                                <div>
                                                    @if($client->skinType)
                                                        <div class="gap-2 d-flex align-items-center">
                                                            @if($client->skinType->getMedia('skin_type_image')->first())
                                                                <img src="{{ $client->skinType->getMedia('skin_type_image')->first()->getUrl() }}" alt="{{ $client->skinType->name }}" class="rounded" style="width: 24px; height: 24px; object-fit: cover;">
                                                            @endif
                                                            <span class="fw-medium">{{ $client->skinType->name }}</span>
                                                            <button class="p-1 btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#skinProfileModal" style="width: 24px; height: 24px; line-height: 1;">
                                                                <i class="ti ti-edit" style="font-size: 12px;"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-primary-subtle btn-sm text-primary" data-bs-toggle="modal" data-bs-target="#skinProfileModal">
                                                            <i class="ti ti-plus fs-xs me-1"></i>Add
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="col-md-4">
                                <div class="gap-3 d-flex justify-content-end">
                                    <div class="text-center">
                                        <div class="mb-1 fs-4 fw-bold text-primary">0</div>
                                        <div class="text-muted fs-xs">Orders</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="mb-1 fs-4 fw-bold text-success">$0</div>
                                        <div class="text-muted fs-xs">Spent</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="mb-1 fs-4 fw-bold text-warning">{{ number_format($client->loyaltyAccount->points ?? 0, 0) }}</div>
                                        <div class="text-muted fs-xs">Points</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Tabs -->
    <div class="col-12">
        <div class="border-0 shadow-sm card">
            <div class="p-0 card-body">
                <ul class="gap-2 p-3 rounded nav nav-pills nav-justified border-bottom" style="border-radius: 150px;" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#orders" role="tab">
                            <i class="mb-1 ti ti-shopping-cart fs-5 d-block"></i>
                            <span class="fs-xs">Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#refunds" role="tab">
                            <i class="mb-1 ti ti-receipt-refund fs-5 d-block"></i>
                            <span class="fs-xs">Refunds</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#shipments" role="tab">
                            <i class="mb-1 ti ti-truck-delivery fs-5 d-block"></i>
                            <span class="fs-xs">Shipments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#reviews" role="tab">
                            <i class="mb-1 ti ti-star fs-5 d-block"></i>
                            <span class="fs-xs">Reviews</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#wishlist" role="tab">
                            <i class="mb-1 ti ti-heart fs-5 d-block"></i>
                            <span class="fs-xs">Wishlist</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#addresses" role="tab">
                            <i class="mb-1 ti ti-map-pin fs-5 d-block"></i>
                            <span class="fs-xs">Addresses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#beauty-info" role="tab">
                            <i class="mb-1 ti ti-sparkles fs-5 d-block"></i>
                            <span class="fs-xs">Beauty Info</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#loyalty-points" role="tab">
                            <i class="mb-1 ti ti-coins fs-5 d-block"></i>
                            <span class="fs-xs">Loyalty Points</span>
                        </a>
                    </li>
                </ul>

                <div class="p-4 tab-content">
                    <!-- Orders Tab -->
                    <div class="tab-pane show active" id="orders" role="tabpanel">
                        @if($orders->isEmpty())
                            <div class="py-5 text-center">
                                <div class="mb-4">
                                    <i class="ti ti-shopping-cart text-primary" style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                                <h5 class="mb-2 fw-semibold">No Orders Yet</h5>
                                <p class="mb-0 text-muted fs-sm">This client hasn't placed any orders yet.</p>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($orders as $order)
                                    <div class="col-12">
                                        <div class="border shadow-sm card">
                                            <div class="card-body">
                                                <div class="mb-3 d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h5 class="mb-1 fw-bold">Order #{{ $order->id }}</h5>
                                                        <p class="mb-1 text-muted fs-sm">
                                                            <i class="ti ti-calendar me-1"></i>
                                                            {{ $order->created_at->format('M d, Y - h:i A') }}
                                                        </p>
                                                        <p class="mb-0 text-muted fs-sm">
                                                            <i class="ti ti-credit-card me-1"></i>
                                                            {{ $order->paymentMethod->name ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                    <div class="text-end">
                                                        @if($order->orderStatus)
                                                            <span class="mb-2 badge d-inline-block" style="background-color: {{ $order->orderStatus->color }};">
                                                                {{ $order->orderStatus->name }}
                                                            </span>
                                                        @endif
                                                        <div class="mt-2">
                                                            <strong class="fs-5 text-primary">{{ number_format($order->total_amount, 2) }} EGP</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="p-2 rounded bg-light">
                                                        <strong class="text-muted fs-sm">
                                                            <i class="ti ti-package me-1"></i>
                                                            {{ $order->items->count() }} {{ $order->items->count() === 1 ? 'Item' : 'Items' }}
                                                        </strong>
                                                        @if($order->items->count() > 0)
                                                            <span class="text-muted fs-xs ms-2">
                                                                ({{ $order->items->first()->product->name ?? 'Product' }}{{ $order->items->count() > 1 ? ' +' . ($order->items->count() - 1) . ' more' : '' }})
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrderDetails({{ $order->id }})">
                                                        <i class="ti ti-eye me-1"></i>
                                                        View Details
                                                    </button>
                                                    @if($order->source === 'POS')
                                                        <span class="badge bg-info align-self-center">
                                                            <i class="ti ti-device-desktop me-1"></i>
                                                            POS Order
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary align-self-center">
                                                            <i class="ti ti-world me-1"></i>
                                                            Online Order
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Refunds Tab -->
                    <div class="tab-pane" id="refunds" role="tabpanel">
                        <div class="py-5 text-center">
                            <div class="mb-4">
                                <i class="ti ti-receipt-refund text-warning" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                            <h5 class="mb-2 fw-semibold">No Refunds</h5>
                            <p class="mb-0 text-muted fs-sm">This client has no refund requests.</p>
                            <p class="mt-2 text-muted fs-xs">
                                <i class="ti ti-info-circle fs-sm me-1"></i>
                                Refund requests with items, reason, status, and amount will appear here
                            </p>
                        </div>
                    </div>

                    <!-- Shipments Tab -->
                    <div class="tab-pane" id="shipments" role="tabpanel">
                        <div class="py-5 text-center">
                            <div class="mb-4">
                                <i class="ti ti-truck-delivery text-info" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                            <h5 class="mb-2 fw-semibold">No Shipments</h5>
                            <p class="mb-0 text-muted fs-sm">No shipment information available.</p>
                            <p class="mt-2 text-muted fs-xs">
                                <i class="ti ti-info-circle fs-sm me-1"></i>
                                Shipment tracking with carrier, tracking number, and status will appear here
                            </p>
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane" id="reviews" role="tabpanel">
                        @if($reviews->isEmpty())
                            <div class="py-5 text-center">
                                <div class="mb-4">
                                    <i class="ti ti-star text-warning" style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                                <h5 class="mb-2 fw-semibold">No Reviews</h5>
                                <p class="mb-0 text-muted fs-sm">This client hasn't left any reviews yet.</p>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($reviews as $review)
                                    <div class="col-12">
                                        <div class="border shadow-sm card">
                                            <div class="card-body">
                                                <div class="d-flex gap-3">
                                                    <!-- Product Image -->
                                                    @if($review->product)
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ $review->product->image }}" 
                                                                 alt="{{ $review->product->name }}" 
                                                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Review Content -->
                                                    <div class="flex-grow-1">
                                                        <div class="mb-2 d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h6 class="mb-1 fw-bold">
                                                                    {{ $review->product->name ?? 'Product' }}
                                                                </h6>
                                                                <div class="mb-2">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= $review->rating)
                                                                            <i class="ti ti-star-filled text-warning"></i>
                                                                        @else
                                                                            <i class="ti ti-star text-muted"></i>
                                                                        @endif
                                                                    @endfor
                                                                    <span class="ms-2 text-muted fs-sm">
                                                                        {{ $review->rating }}/5
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">
                                                                <i class="ti ti-calendar me-1"></i>
                                                                {{ $review->created_at->format('M d, Y') }}
                                                            </small>
                                                        </div>
                                                        
                                                        @if($review->comment)
                                                            <div class="p-3 rounded bg-light">
                                                                <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Wishlist Tab -->
                    <div class="tab-pane" id="wishlist" role="tabpanel">
                        <div class="py-5 text-center">
                            <div class="mb-4">
                                <i class="ti ti-heart text-danger" style="font-size: 3rem; opacity: 0.3;"></i>
                            </div>
                            <h5 class="mb-2 fw-semibold">Wishlist is Empty</h5>
                            <p class="mb-0 text-muted fs-sm">No items in the wishlist.</p>
                            <p class="mt-2 text-muted fs-xs">
                                <i class="ti ti-info-circle fs-sm me-1"></i>
                                Wishlisted products with images, prices, and add dates will appear here
                            </p>
                        </div>
                    </div>

                    <!-- Addresses Tab -->
                    <div class="tab-pane" id="addresses" role="tabpanel">
                        @include('admin.pages.client-profile.addresses.section')
                    </div>

                    <!-- Beauty Info Tab -->
                    <div class="tab-pane" id="beauty-info" role="tabpanel">
                        @include('admin.pages.client-profile.beauty-info.section')
                    </div>

                    <!-- Loyalty Points Tab -->
                    <div class="tab-pane" id="loyalty-points" role="tabpanel">
                        @include('admin.pages.client-profile.loyalty.section')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">
                    <i class="ti ti-receipt me-2"></i>
                    Order Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading order details...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewOrderDetails(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
    modal.show();
    
    // Reset content
    document.getElementById('orderDetailsContent').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading order details...</p>
        </div>
    `;
    
    // Fetch order details
    fetch(`/admin/orders/${orderId}/details`)
        .then(response => response.json())
        .then(data => {
            renderOrderDetails(data);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('orderDetailsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="ti ti-alert-circle me-2"></i>
                    Failed to load order details. Please try again.
                </div>
            `;
        });
}

function renderOrderDetails(order) {
    const statusColor = order.order_status?.color || '#6c757d';
    const statusName = order.order_status?.name || 'N/A';
    
    let itemsHtml = '';
    if (order.items && order.items.length > 0) {
        itemsHtml = order.items.map(item => {
            const productName = item.product?.name || 'Unknown Product';
            const variantName = item.variant ? ` (${item.variant.name})` : '';
            const imageUrl = item.product?.image || '/images/placeholder.png';
            
            return `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="${imageUrl}" alt="${productName}" 
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            <div>
                                <div class="fw-semibold">${productName}${variantName}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">${item.qty}</td>
                    <td class="text-end">${parseFloat(item.price).toFixed(2)} EGP</td>
                    <td class="text-end fw-bold">${parseFloat(item.subtotal).toFixed(2)} EGP</td>
                </tr>
            `;
        }).join('');
    } else {
        itemsHtml = `
            <tr>
                <td colspan="4" class="text-center text-muted">No items found</td>
            </tr>
        `;
    }
    
    const content = `
        <div class="row">
            <div class="col-md-8">
                <div class="card border mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-package me-2"></i>
                            Order Items
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${itemsHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                ${order.client_notes ? `
                <div class="card border mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-message me-2"></i>
                            Client Notes
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">${order.client_notes}</p>
                    </div>
                </div>
                ` : ''}
                
                ${order.admin_notes ? `
                <div class="card border mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-note me-2"></i>
                            Admin Notes
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">${order.admin_notes}</p>
                    </div>
                </div>
                ` : ''}
            </div>
            
            <div class="col-md-4">
                <div class="card border mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-info-circle me-2"></i>
                            Order Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Order ID</small>
                            <strong>#${order.id}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge" style="background-color: ${statusColor};">${statusName}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Date</small>
                            <strong>${new Date(order.created_at).toLocaleString()}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Payment Method</small>
                            <strong>${order.payment_method?.name || 'N/A'}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Source</small>
                            <span class="badge ${order.source === 'POS' ? 'bg-info' : 'bg-secondary'}">
                                <i class="ti ti-${order.source === 'POS' ? 'device-desktop' : 'world'} me-1"></i>
                                ${order.source || 'N/A'}
                            </span>
                        </div>
                        ${order.is_paid ? `
                        <div class="mb-3">
                            <span class="badge bg-success">
                                <i class="ti ti-check me-1"></i>
                                Paid
                            </span>
                        </div>
                        ` : ''}
                    </div>
                </div>
                
                <div class="card border">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-calculator me-2"></i>
                            Order Summary
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <strong>${parseFloat(order.subtotal_amount || 0).toFixed(2)} EGP</strong>
                        </div>
                        ${order.discount_amount > 0 ? `
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Discount</span>
                            <strong class="text-danger">-${parseFloat(order.discount_amount).toFixed(2)} EGP</strong>
                        </div>
                        ` : ''}
                        ${order.tax_amount > 0 ? `
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax (${order.tax_rate}%)</span>
                            <strong>${parseFloat(order.tax_amount).toFixed(2)} EGP</strong>
                        </div>
                        ` : ''}
                        ${order.shipping_fee > 0 ? `
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <strong>${parseFloat(order.shipping_fee).toFixed(2)} EGP</strong>
                        </div>
                        ` : ''}
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5 text-primary">${parseFloat(order.total_amount).toFixed(2)} EGP</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('orderDetailsContent').innerHTML = content;
}
</script>
