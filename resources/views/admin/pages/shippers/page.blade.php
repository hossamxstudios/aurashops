<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Shipper
        </span>
        <h3 class="fw-bold">
            Shippers
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
                                <input type="text" id="searchShippers" class="form-control" placeholder="Search by carrier name...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Carrier Name</th>
                                <th>Delivery</th>
                                <th>COD Fee</th>
                                <th>COD Range</th>
                                <th>Rates</th>
                                <th>Status</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="shippersTableBody">
                            @forelse($shippers as $shipper)
                                <tr>
                                    <td>{{ $shipper->id }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $shipper->carrier_name }}</span>
                                        <br><small class="text-muted">{{ $shipper->delivery_days }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $shipper->delivery_time }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ number_format($shipper->cod_fee, 2) }} EGP</span>
                                        <br><small class="badge bg-secondary">{{ ucfirst($shipper->cod_fee_type) }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ number_format($shipper->cod_min, 2) }} - {{ number_format($shipper->cod_max, 2) }} EGP
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark">{{ $shipper->shipping_rates_count }} rates</span>
                                    </td>
                                    <td>
                                        @if($shipper->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                        @if($shipper->is_support_cod)
                                            <br><span class="badge bg-info small mt-1">COD</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light" onclick="editShipper({{ $shipper->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteShipper({{ $shipper->id }}, '{{ addslashes($shipper->carrier_name) }}')" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No shippers found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $shippers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.shippers.createModal')
@include('admin.pages.shippers.editModal')
@include('admin.pages.shippers.deleteModal')

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter shippers table
    document.getElementById('searchShippers').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('shippersTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const carrierName = row.cells[1]?.textContent.toLowerCase() || '';

            if (carrierName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
