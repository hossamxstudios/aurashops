<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Shipping Rate
        </span>
        <h3 class="fw-bold">
            Shipping Rates
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
                                <input type="text" id="searchRates" class="form-control" placeholder="Search by shipper, city...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Shipper</th>
                                <th>City</th>
                                <th>Rate</th>
                                <th>COD Fee</th>
                                <th>COD Type</th>
                                <th>Free Shipping</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ratesTableBody">
                            @forelse($shippingRates as $rate)
                                <tr>
                                    <td>{{ $rate->id }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $rate->shipper->carrier_name }}</span>
                                        <br><small class="text-muted">{{ $rate->shipper->delivery_days }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $rate->city->cityName }}</span>
                                        <br><small class="text-muted">{{ $rate->city->cityCode }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">${{ number_format($rate->rate, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">${{ number_format($rate->cod_fee, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($rate->cod_type) }}</span>
                                    </td>
                                    <td>
                                        @if($rate->is_free_shipping)
                                            <span class="badge bg-success">Yes</span>
                                            <br><small class="text-muted">Above ${{ number_format($rate->free_shipping_threshold, 2) }}</small>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light" onclick="editRate({{ $rate->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteRate({{ $rate->id }}, '{{ addslashes($rate->shipper->name) }} - {{ addslashes($rate->city->cityName) }}')" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No shipping rates found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $shippingRates->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.shipping_rates.createModal')
@include('admin.pages.shipping_rates.editModal')
@include('admin.pages.shipping_rates.deleteModal')

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter shipping rates table
    document.getElementById('searchRates').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('ratesTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const shipperName = row.cells[1]?.textContent.toLowerCase() || '';
            const cityName = row.cells[2]?.textContent.toLowerCase() || '';

            if (shipperName.includes(searchTerm) || cityName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
