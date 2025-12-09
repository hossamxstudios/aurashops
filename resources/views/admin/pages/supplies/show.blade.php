<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Supply Details</title>
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
                            <a href="{{ route('admin.supplies.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back
                            </a>
                        </div>
                        <div class="col-auto">
                            <h3 class="fw-bold mb-0">Supply Order #{{ $supply->id }}</h3>
                        </div>
                        <div class="col-auto">
                            @if(!$supply->is_delivered && $supply->status !== 'cancelled')
                                <button class="btn btn-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                    <i data-lucide="plus" class="icon-sm me-1"></i> Add Item
                                </button>
                                @if($supply->supplyItems->count() > 0)
                                    <form action="{{ route('admin.supplies.complete', $supply->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Complete this supply and update stock?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm shadow-sm">
                                            <i data-lucide="check-circle" class="icon-sm me-1"></i> Complete & Update Stock
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-lg-8">
                            <!-- Supply Items -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="package" class="icon-sm me-2"></i>Supply Items
                                        <span class="badge bg-primary ms-2">{{ $supply->supplyItems->count() }}</span>
                                    </h5>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Variant</th>
                                                    <th>Qty</th>
                                                    <th>Unit Price</th>
                                                    <th>Total</th>
                                                    <th width="60">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($supply->supplyItems as $item)
                                                    <tr>
                                                        <td>
                                                            @if($item->product)
                                                                <span class="fw-bold">{{ $item->product->name }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($item->variant)
                                                                <code class="small">{{ $item->variant->sku }}</code>
                                                            @endif
                                                        </td>
                                                        <td><span class="badge bg-secondary">{{ $item->qty }}</span></td>
                                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                                        <td><strong>{{ number_format($item->total, 2) }}</strong></td>
                                                        <td>
                                                            @if(!$supply->is_delivered)
                                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteItem({{ $item->id }})" title="Delete">
                                                                    <i data-lucide="trash-2" class="icon-sm"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-4">
                                                            <i data-lucide="inbox" class="icon-lg text-muted mb-2"></i>
                                                            <p class="text-muted mb-0">No items added yet</p>
                                                            <small class="text-muted">Click "Add Item" to add products to this supply</small>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="calculator" class="icon-sm me-2"></i>Financial Summary
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td>Subtotal:</td>
                                                    <td class="text-end"><strong>{{ number_format($supply->subtotal, 2) }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Tax ({{ $supply->tax_rate }}%):</td>
                                                    <td class="text-end"><strong>{{ number_format($supply->tax_amount, 2) }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Discount:</td>
                                                    <td class="text-end text-success"><strong>-{{ number_format($supply->discount_amount, 2) }}</strong></td>
                                                </tr>
                                                <tr class="border-top">
                                                    <td><strong>Total:</strong></td>
                                                    <td class="text-end"><h5 class="mb-0 text-primary">{{ number_format($supply->total, 2) }}</h5></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Supply Information -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="info" class="icon-sm me-2"></i>Supply Information
                                    </h5>
                                    
                                    <div class="mb-3">
                                        <label class="text-muted small">Supplier</label>
                                        <div class="fw-bold">
                                            @if($supply->supplier)
                                                {{ $supply->supplier->name }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-muted small">Warehouse</label>
                                        <div class="fw-bold">
                                            @if($supply->warehouse)
                                                {{ $supply->warehouse->name }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-muted small">Status</label>
                                        <div>
                                            <span class="badge bg-{{ $supply->status_badge_color }}">
                                                {{ ucfirst($supply->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-muted small">Delivery Status</label>
                                        <div>
                                            @if($supply->is_delivered)
                                                <span class="badge bg-success">Delivered</span>
                                                <br><small class="text-muted">Stock updated</small>
                                            @else
                                                <span class="badge bg-warning">Not Delivered</span>
                                                <br><small class="text-muted">Stock not updated yet</small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-muted small">Created At</label>
                                        <div><small>{{ $supply->created_at->format('M d, Y H:i') }}</small></div>
                                    </div>

                                    <div class="mb-0">
                                        <label class="text-muted small">Last Updated</label>
                                        <div><small>{{ $supply->updated_at->format('M d, Y H:i') }}</small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.pages.supplies.addItemModal')

                    <!-- Delete Item Form -->
                    <form id="deleteItemForm" method="POST" style="display: none;">
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
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function deleteItem(itemId) {
            if (confirm('Are you sure you want to delete this item?')) {
                const form = document.getElementById('deleteItemForm');
                form.action = `/admin/supplies/{{ $supply->id }}/items/${itemId}`;
                form.submit();
            }
        }
    </script>
</body>
</html>
