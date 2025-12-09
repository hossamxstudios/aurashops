<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Stock
        </span>
        <h3 class="fw-bold">
            Inventory Stocks
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

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
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
                                <input type="text" id="searchStocks" class="form-control" placeholder="Search by product, variant, or warehouse...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Warehouse</th>
                                <th>Quantity</th>
                                <th>Reorder Qty</th>
                                <th>Status</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="stocksTableBody">
                            @forelse($stocks as $stock)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($stock->product)
                                                <div>
                                                    <span class="fw-bold">{{ $stock->product->name }}</span>
                                                    <br><small class="text-muted">ID: {{ $stock->product->id }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($stock->variant)
                                            <span>{{ $stock->variant->sku }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($stock->warehouse)
                                            <span>{{ $stock->warehouse->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $stock->status_badge_color }} fs-6 px-2">
                                            {{ $stock->qty }}
                                        </span>
                                        @if($stock->qty <= 0)
                                            <br><small class="text-danger fw-bold">Out of Stock</small>
                                        @elseif($stock->isLowStock())
                                            <br><small class="text-warning fw-bold">Low Stock</small>
                                        @endif
                                    </td>
                                    <td>{{ $stock->reorder_qty }}</td>
                                    <td>
                                        @if($stock->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.stocks.show', $stock->id) }}" class="btn btn-sm btn-outline-primary" title="View Details & Logs" data-bs-toggle="tooltip">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-success" onclick="quickAddMovement({{ $stock->id }})" title="Add Movement" data-bs-toggle="tooltip">
                                                <i data-lucide="activity" class="icon-sm"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editStock({{ $stock->id }})" title="Edit" data-bs-toggle="tooltip">
                                                <i data-lucide="edit-3" class="icon-sm"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteStock({{ $stock->id }}, '{{ $stock->product ? $stock->product->name : 'Stock' }}')" title="Delete" data-bs-toggle="tooltip">
                                                <i data-lucide="trash-2" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No stock records found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $stocks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.stocks.createModal')
@include('admin.pages.stocks.editModal')
@include('admin.pages.stocks.deleteModal')

<style>
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    .btn-group .btn-outline-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    .btn-group .btn-outline-success:hover {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }
    .btn-group .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }
    .btn-group .btn-outline-danger:hover {
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

    // Quick add movement - redirect to stock details page
    function quickAddMovement(stockId) {
        window.location.href = `/admin/stocks/${stockId}`;
    }

    // Search/Filter stocks table
    document.getElementById('searchStocks').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('stocksTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const product = row.cells[0]?.textContent.toLowerCase() || '';
            const variant = row.cells[1]?.textContent.toLowerCase() || '';
            const warehouse = row.cells[2]?.textContent.toLowerCase() || '';

            if (product.includes(searchTerm) || variant.includes(searchTerm) || warehouse.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
