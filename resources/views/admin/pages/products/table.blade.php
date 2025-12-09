<div class="row">
    @forelse($products as $product)
        <div class="mb-3 col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
            <div class="card h-100">
                <div class="card-body">
                    <!-- Product Image -->
                    <div class="mb-3 text-center">
                        @if($product->getMedia('product_thumbnail')->first())
                            <img src="{{ $product->getMedia('product_thumbnail')->first()->getUrl() }}" alt="{{ $product->name }}" class="rounded img-fluid" style="max-height: 180px; object-fit: cover;">
                        @else
                            <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="ti ti-package text-primary" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="mb-3">
                        <h5 class="mb-1">{{ $product->name }}</h5>
                        <!-- Badges -->
                        <div class="mb-2">
                            @if($product->type === 'simple')
                                <span class="badge bg-info-subtle text-info fs-xs">Simple</span>
                            @elseif($product->type === 'variant')
                                <span class="badge bg-warning-subtle text-warning fs-xs">Variant</span>
                            @elseif($product->type === 'bundle')
                                <span class="badge bg-success-subtle text-success fs-xs">Bundle</span>
                            @endif

                            @if($product->is_featured)
                                <span class="badge bg-primary-subtle text-primary fs-xs">Featured</span>
                            @endif

                            @if(!$product->is_active)
                                <span class="badge bg-danger-subtle text-danger fs-xs">Inactive</span>
                            @endif
                        </div>
                        <!-- Meta Info -->
                        <div class="text-muted fs-xs">
                            @if($product->sku)
                                <div><i class="ti ti-barcode fs-xs me-1"></i>SKU: {{ $product->sku }}</div>
                            @endif
                            @if($product->barcode)
                                <div><i class="ti ti-scan fs-xs me-1"></i>Barcode: {{ $product->barcode }}</div>
                            @endif
                            @if($product->brand)
                                <div><i class="ti ti-tag fs-xs me-1"></i>{{ $product->brand->name }}</div>
                            @endif
                            @if($product->gender)
                                <div><i class="ti ti-user fs-xs me-1"></i>{{ $product->gender->name }}</div>
                            @endif
                        </div>
                        <!-- No Barcode Alert -->
                        @if(!$product->barcode)
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100" onclick="openBarcodeScanner({{ $product->id }}, '{{ $product->name }}')">
                                    <i class="ti ti-qrcode me-1"></i>Scan Barcode
                                </button>
                            </div>
                        @endif
                    </div>
                    <!-- Price -->
                    <div class="mb-3">
                        <div class="fw-bold text-primary fs-5">
                            @if($product->sale_price > 0)
                                ${{ number_format($product->sale_price, 2) }}
                                <small class="text-muted text-decoration-line-through fs-sm">${{ number_format($product->price, 2) }}</small>
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </div>
                        @if($product->type === 'variant')
                            <small class="text-muted">{{ $product->variants->count() }} variants</small>
                        @elseif($product->type === 'bundle')
                            <small class="text-muted">{{ $product->bundleItems->count() }} items</small>
                        @endif
                    </div>
                    <!-- Actions -->
                    <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                        <div class="gap-1 d-flex">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-light btn-sm" title="View">
                                <i class="ti ti-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-light btn-sm" title="Edit">
                                <i class="ti ti-edit"></i>
                            </a>
                            <button class="btn btn-danger-subtle btn-sm text-danger" onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')" title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="py-5 text-center card-body">
                    <i class="ti ti-package text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 mb-2">No Products Found</h5>
                    <p class="text-muted">Start by adding your first product</p>
                    <a href="{{ route('admin.products.create') }}" class="mt-2 btn btn-primary">
                        <i class="ti ti-plus me-1"></i>Add New Product
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
    <div class="mt-3 row">
        <div class="col-12">
            <div class="card">
                <div class="py-2 card-body">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endif
