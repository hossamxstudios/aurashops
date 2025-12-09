<div class="row">
    @forelse($brands as $brand)
        <div class="col-md-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-start justify-content-between">
                        <div class="gap-3 d-flex align-items-center flex-grow-1">
                            @if($brand->getMedia('brand_logo')->first())
                                <img src="{{ $brand->getMedia('brand_logo')->first()->getUrl() }}" alt="{{ $brand->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="ti ti-tag text-primary" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $brand->name }}</h5>
                                @if($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank" class="text-muted fs-xs">
                                        <i class="ti ti-world fs-xs me-1"></i>Website
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($brand->details)
                        <p class="text-muted fs-sm mb-3">{{ Str::limit($brand->details, 80) }}</p>
                    @endif

                    <div class="pt-3 mt-3 d-flex justify-content-end align-items-center border-top">
                        <div class="gap-1 d-flex">
                            <button class="btn btn-light btn-sm" onclick="editBrand({{ $brand->id }})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger-subtle btn-sm text-danger" onclick="deleteBrand({{ $brand->id }}, '{{ $brand->name }}')" title="Delete">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="py-5 text-center card-body">
                    <i class="ti ti-tag text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 mb-2">No Brands Found</h5>
                    <p class="text-muted">Start by adding your first brand</p>
                    <button class="mt-2 btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addOffCanvas">
                        <i class="ti ti-plus me-1"></i>Add New Brand
                    </button>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($brands->hasPages())
    <div class="mt-3 row">
        <div class="col-12">
            <div class="card">
                <div class="py-2 card-body">
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
    </div>
@endif
