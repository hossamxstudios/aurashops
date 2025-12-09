<div class="row row-cols-xxl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3">
    @forelse ($skin_types as $skinType)
        <div class="col">
            <div class="card card-hovered shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if ($skinType->getMedia('skin_type_image')->first())
                                    <div class="rounded" style="overflow: hidden; width: 80px; height: 80px;">
                                        <img src="{{ $skinType->getMedia('skin_type_image')->first()->getUrl() }}" 
                                             alt="{{ $skinType->name }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="bg-success-subtle rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="ti ti-droplet text-success fs-2"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $skinType->name }}</h5>
                                    @if($skinType->details)
                                        <p class="text-muted fs-xs mb-1 text-truncate" style="max-width: 180px;" title="{{ $skinType->details }}">
                                            {{ Str::limit($skinType->details, 50) }}
                                        </p>
                                    @endif
                                    <p class="text-muted fs-xs mb-0">
                                        <i class="ti ti-calendar fs-sm me-1"></i>
                                        Created {{ $skinType->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dropdown">
                            <a href="#" class="btn btn-icon btn-ghost-light text-muted btn-sm" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editSkinType({{ $skinType->id }})">
                                        <i class="ti ti-edit me-2 fs-sm"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteSkinType({{ $skinType->id }}, '{{ $skinType->name }}')">
                                        <i class="ti ti-trash me-2 fs-sm"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="border-top pt-2 mt-3">
                        <div class="text-center">
                            <span class="fs-sm fw-semibold text-success me-1">{{ $skinType->clients()->count() }}</span>
                            <span class="text-muted fs-xs">Clients</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="py-5 text-center">
                <div class="mb-4">
                    <i class="ti ti-droplet text-muted" style="font-size: 4rem; opacity: 0.2;"></i>
                </div>
                <h5 class="mb-2 fw-semibold text-muted">No Skin Types Yet</h5>
                <p class="text-muted fs-sm mb-3">Start by adding your first skin type</p>
                <button class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#addOffCanvas">
                    <i class="ti ti-plus me-1"></i>Add Skin Type
                </button>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($skin_types->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $skin_types->links() }}
            </div>
        </div>
    </div>
@endif
