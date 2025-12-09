<div class="row">
    @forelse($categories as $category)
        <div class="col-md-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-start justify-content-between">
                        <div class="gap-3 d-flex align-items-center flex-grow-1">
                            @if($category->getMedia('category_image')->first())
                                <img src="{{ $category->getMedia('category_image')->first()->getUrl() }}" alt="{{ $category->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="ti ti-folder text-primary" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $category->name }}</h5>
                                @if($category->gender)
                                    <span class="badge bg-info-subtle text-info fs-xs">{{ $category->gender->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 d-flex justify-content-between align-items-center border-top">
                        <small class="text-muted">
                            <i class="ti ti-folders fs-sm me-1"></i>{{ $category->children->count() }} Sub-categories
                        </small>
                        <div class="gap-1 d-flex">
                            @if($category->children->count() > 0)
                                <button class="btn btn-info-subtle btn-sm text-info" data-bs-toggle="modal" data-bs-target="#subcategoriesModal{{ $category->id }}" title="View Subcategories">
                                    <i class="ti ti-eye"></i>
                                </button>
                            @endif
                            <button class="btn btn-light btn-sm" onclick="editCategory({{ $category->id }})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger-subtle btn-sm text-danger" onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')" title="Delete">
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
                    <i class="ti ti-folder text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 mb-2">No Categories Found</h5>
                    <p class="text-muted">Start by adding your first category</p>
                    <button class="mt-2 btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addOffCanvas">
                        <i class="ti ti-plus me-1"></i>Add New Category
                    </button>
                </div>
            </div>
        </div>
    @endforelse
</div>

{{-- Subcategories Modals --}}
@foreach($categories as $category)
    @if($category->children->count() > 0)
        <div class="modal fade" id="subcategoriesModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ti ti-folders me-2"></i>
                            Subcategories of "{{ $category->name }}"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            @foreach($category->children as $subcategory)
                                <div class="col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="mb-3 d-flex align-items-center">
                                                @if($subcategory->getMedia('category_image')->first())
                                                    <img src="{{ $subcategory->getMedia('category_image')->first()->getUrl() }}"
                                                         alt="{{ $subcategory->name }}"
                                                         class="rounded me-3"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center me-3"
                                                         style="width: 50px; height: 50px;">
                                                        <i class="ti ti-folder text-primary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $subcategory->name }}</h6>
                                                    <small class="text-muted">{{ $subcategory->slug }}</small>
                                                </div>
                                            </div>
                                            <div class="gap-1 d-flex justify-content-end">
                                                <button class="btn btn-light btn-sm"
                                                        onclick="editCategory({{ $subcategory->id }})"
                                                        title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <button class="btn btn-danger-subtle btn-sm text-danger"
                                                        onclick="deleteCategory({{ $subcategory->id }}, '{{ $subcategory->name }}')"
                                                        title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<!-- Pagination -->
@if($categories->hasPages())
    <div class="mt-3 row">
        <div class="col-12">
            <div class="card">
                <div class="py-2 card-body">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endif
