<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Stock Details</title>
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
                            <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back
                            </a>
                        </div>
                        <div class="col-auto">
                            <h3 class="fw-bold mb-0">
                                Stock Details #{{ $stock->id }}
                            </h3>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addStockLogModal">
                                <i data-lucide="plus" class="icon-sm me-1"></i> Add Movement
                            </button>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Stock Information -->
                    <div class="row mt-3">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="box" class="icon-sm me-2"></i>Stock Information
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Product</label>
                                            <div class="fw-bold">
                                                @if($stock->product)
                                                    {{ $stock->product->name }}
                                                    <br><small class="text-muted">ID: {{ $stock->product->id }}</small>
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Variant</label>
                                            <div class="fw-bold">
                                                @if($stock->variant)
                                                    <code>{{ $stock->variant->sku }}</code>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Warehouse</label>
                                            <div class="fw-bold">
                                                @if($stock->warehouse)
                                                    {{ $stock->warehouse->name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Status</label>
                                            <div>
                                                @if($stock->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Current Quantity</label>
                                            <div>
                                                <span class="badge bg-{{ $stock->status_badge_color }} fs-5 px-3 py-2">
                                                    {{ $stock->qty }}
                                                </span>
                                                @if($stock->qty <= 0)
                                                    <br><small class="text-danger fw-bold">Out of Stock</small>
                                                @elseif($stock->isLowStock())
                                                    <br><small class="text-warning fw-bold">Low Stock</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-muted small">Reorder Quantity</label>
                                            <div class="fw-bold">{{ $stock->reorder_qty }}</div>
                                            <small class="text-muted">Alert when stock falls below this level</small>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="text-muted small">Last Updated</label>
                                            <div><small>{{ $stock->updated_at->format('M d, Y H:i') }}</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Logs Timeline -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i data-lucide="activity" class="icon-sm me-2"></i>Stock Movements
                                        <span class="badge bg-primary ms-2">{{ $stock->stockLogs->count() }}</span>
                                    </h5>
                                    
                                    <div style="max-height: 500px; overflow-y: auto;">
                                        @forelse($stock->stockLogs as $log)
                                            <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-sm bg-{{ $log->type_badge_color }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                        <i data-lucide="{{ $log->type_icon }}" class="icon-sm text-{{ $log->type_badge_color }}"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <span class="badge bg-{{ $log->type_badge_color }} mb-1">{{ ucfirst($log->type) }}</span>
                                                            <div class="fw-bold">
                                                                @if(in_array($log->type, ['add', 'purchase', 'return']))
                                                                    <span class="text-success">+{{ $log->qty }}</span>
                                                                @elseif(in_array($log->type, ['remove', 'sale', 'damage', 'loss']))
                                                                    <span class="text-danger">-{{ $log->qty }}</span>
                                                                @else
                                                                    {{ $log->qty }}
                                                                @endif
                                                                units
                                                            </div>
                                                            @if($log->cost_per_unit > 0)
                                                                <div class="mt-1">
                                                                    <small class="text-muted">
                                                                        Cost: {{ number_format($log->cost_per_unit, 2) }} × {{ $log->qty }} = 
                                                                        <strong>{{ number_format($log->total_cost, 2) }}</strong>
                                                                    </small>
                                                                </div>
                                                            @endif
                                                            @if($log->reference_type && $log->reference_id)
                                                                <div class="mt-1">
                                                                    <small class="text-muted">
                                                                        <i data-lucide="link" class="icon-sm"></i>
                                                                        {{ ucfirst($log->reference_type) }}: {{ $log->reference_id }}
                                                                    </small>
                                                                </div>
                                                            @endif
                                                            @if($log->notes)
                                                                <div class="mt-1 small">{{ $log->notes }}</div>
                                                            @endif
                                                            <div class="mt-1">
                                                                <small class="text-muted">
                                                                    <i data-lucide="clock" class="icon-sm"></i>
                                                                    {{ $log->created_at->format('M d, Y H:i') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteLog({{ $log->id }})" title="Delete" data-bs-toggle="tooltip">
                                                                <i data-lucide="trash-2" class="icon-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-4">
                                                <i data-lucide="inbox" class="icon-lg text-muted mb-2"></i>
                                                <p class="text-muted mb-0">No stock movements yet</p>
                                                <small class="text-muted">Add movements to track inventory changes</small>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Stock Log Modal -->
                    @include('admin.pages.stocks.addStockLogModal')

                    <!-- Delete Log Form (Hidden) -->
                    <form id="deleteLogForm" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    
    <style>
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
    </style>
    
    <script>
        // Re-initialize Lucide icons after page load
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        function deleteLog(logId) {
            if (confirm('Are you sure you want to delete this stock log?')) {
                const form = document.getElementById('deleteLogForm');
                form.action = `/admin/stocks/{{ $stock->id }}/logs/${logId}`;
                form.submit();
            }
        }
    </script>
</body>
</html>
