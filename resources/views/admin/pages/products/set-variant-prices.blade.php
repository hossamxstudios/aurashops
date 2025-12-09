<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Set Variant Prices</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="py-1 pt-4 row justify-content-center">
                        <div class="col-xxl-9 col-xl-10">
                            <div class="mb-4 text-center">
                                <a href="{{ route('admin.products.index') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
                                    <i data-lucide="arrow-left" class="fs-sm me-1"></i> Back to Products
                                </a>
                                <h3 class="mt-3 fw-bold">Set Variant Prices</h3>
                                <p class="text-muted">Configure individual prices for each product variant</p>

                                <!-- Product Info -->
                                <div class="p-3 mt-3 rounded bg-light">
                                    <div class="gap-3 d-flex align-items-center justify-content-center">
                                        @if($product->getMedia('product_thumbnail')->first())
                                            <img src="{{ $product->getMedia('product_thumbnail')->first()->getUrl() }}"
                                                 alt="{{ $product->name }}"
                                                 class="rounded"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h5 class="mb-1 fw-bold">{{ $product->name }}</h5>
                                            <p class="mb-0 text-muted">{{ $product->variants->count() }} variants generated</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.main.messages')

                    <!-- Variants Pricing Form -->
                    <div class="row justify-content-center">
                        <div class="col-xxl-9 col-xl-10">
                            <form action="{{ route('admin.products.update-variant-prices', $product->id) }}" method="POST">
                                @csrf

                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-1 fw-semibold">Configure Variant Pricing</h5>
                                                <p class="mb-0 text-muted fs-sm">Set individual prices for each variant combination</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning">{{ $product->variants->count() }} Variants</span>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table align-middle table-hover">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="border-0" style="width: 40%;">Variant</th>
                                                        <th class="border-0" style="width: 20%;">SKU</th>
                                                        <th class="border-0" style="width: 20%;">Regular Price</th>
                                                        <th class="border-0" style="width: 20%;">Sale Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->variants as $variant)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="rounded me-2 bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                        <i class="ti ti-box text-primary"></i>
                                                                    </div>
                                                                    <div>
                                                                        <div class="fw-semibold">{{ $variant->name }}</div>
                                                                        <small class="text-muted">{{ $variant->getVariantName() }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                       class="form-control form-control-sm"
                                                                       name="variants[{{ $variant->id }}][sku]"
                                                                       value="{{ $variant->sku }}"
                                                                       placeholder="SKU">
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text">$</span>
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           name="variants[{{ $variant->id }}][price]"
                                                                           value="{{ $variant->price }}"
                                                                           step="0.01"
                                                                           min="0"
                                                                           required>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text">$</span>
                                                                    <input type="number"
                                                                           class="form-control"
                                                                           name="variants[{{ $variant->id }}][sale_price]"
                                                                           value="{{ $variant->sale_price ?: '' }}"
                                                                           step="0.01"
                                                                           min="0"
                                                                           placeholder="Optional">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Bulk Actions -->
                                        <div class="p-3 mt-4 rounded border bg-light">
                                            <h6 class="mb-3 fw-semibold">Quick Actions</h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium fs-sm">Apply Same Regular Price to All</label>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control" id="bulk_price" step="0.01" min="0" placeholder="0.00">
                                                        <button type="button" class="btn btn-outline-primary" onclick="applyBulkPrice()">
                                                            <i class="ti ti-arrows-down"></i> Apply
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium fs-sm">Apply Same Sale Price to All</label>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" class="form-control" id="bulk_sale_price" step="0.01" min="0" placeholder="0.00">
                                                        <button type="button" class="btn btn-outline-success" onclick="applyBulkSalePrice()">
                                                            <i class="ti ti-arrows-down"></i> Apply
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-medium fs-sm">Clear All Sale Prices</label>
                                                    <div class="d-grid">
                                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearSalePrices()">
                                                            <i class="ti ti-x"></i> Clear Sale Prices
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mb-4 text-center">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                                        <i class="ti ti-arrow-left me-1"></i>Skip for Now
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-check me-1"></i>Save Variant Prices
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <script>
        function applyBulkPrice() {
            const bulkPrice = document.getElementById('bulk_price').value;
            if (bulkPrice) {
                document.querySelectorAll('input[name*="[price]"]').forEach(input => {
                    input.value = bulkPrice;
                });
            }
        }

        function applyBulkSalePrice() {
            const bulkSalePrice = document.getElementById('bulk_sale_price').value;
            if (bulkSalePrice) {
                document.querySelectorAll('input[name*="[sale_price]"]').forEach(input => {
                    input.value = bulkSalePrice;
                });
            }
        }

        function clearSalePrices() {
            if (confirm('Are you sure you want to clear all sale prices?')) {
                document.querySelectorAll('input[name*="[sale_price]"]').forEach(input => {
                    input.value = '';
                });
            }
        }
    </script>
</body>
</html>
