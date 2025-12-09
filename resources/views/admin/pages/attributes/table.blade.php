<div class="row">
    @forelse($attributes as $attribute)
        <div class="col-md-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="mb-3 d-flex align-items-start justify-content-between">
                        <div class="gap-3 d-flex align-items-center flex-grow-1">
                            <div class="rounded bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="ti ti-tag text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $attribute->name }}</h5>
                                @if($attribute->is_active)
                                    <span class="badge bg-success-subtle text-success fs-xs">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger fs-xs">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 mt-3 d-flex justify-content-between align-items-center border-top">
                        <small class="text-muted">
                            <i class="ti ti-list fs-sm me-1"></i>{{ $attribute->values->count() }} Values
                        </small>
                        <div class="gap-1 d-flex">
                            @if($attribute->values->count() > 0)
                                <button class="btn btn-info-subtle btn-sm text-info" data-bs-toggle="modal" data-bs-target="#valuesModal{{ $attribute->id }}" title="View Values">
                                    <i class="ti ti-eye"></i>
                                </button>
                            @endif
                            <button class="btn btn-light btn-sm" onclick="editAttribute({{ $attribute->id }})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger-subtle btn-sm text-danger" onclick="deleteAttribute({{ $attribute->id }})" title="Delete">
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
                    <h5 class="mt-3 mb-2">No Attributes Found</h5>
                    <p class="text-muted">Start by adding your first attribute</p>
                    <button class="mt-2 btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addOffCanvas">
                        <i class="ti ti-plus me-1"></i>Add New Attribute
                    </button>
                </div>
            </div>
        </div>
    @endforelse
</div>

{{-- Attribute Values Modals --}}
@foreach($attributes as $attribute)
    @if($attribute->values->count() > 0)
        <div class="modal fade" id="valuesModal{{ $attribute->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ti ti-list me-2"></i>
                            Values of "{{ $attribute->name }}"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            @foreach($attribute->values as $value)
                                <div class="col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded bg-secondary-subtle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                        <i class="ti ti-point text-secondary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $value->name }}</h6>
                                                    </div>
                                                </div>
                                                @if($value->is_active)
                                                    <span class="badge bg-success-subtle text-success fs-xs">Active</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger fs-xs">Inactive</span>
                                                @endif
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

{{-- Pagination --}}
@if(method_exists($attributes, 'hasPages') && $attributes->hasPages())
    <div class="mt-3 row">
        <div class="col-12">
            <div class="card">
                <div class="py-2 card-body">
                    {{ $attributes->links() }}
                </div>
            </div>
        </div>
    </div>
@endif
