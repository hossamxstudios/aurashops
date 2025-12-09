<div class="row">
    @forelse($concerns as $concern)
        <div class="col-md-4 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            @if($concern->getMedia('concern_image')->first())
                                <img src="{{ $concern->getMedia('concern_image')->first()->getUrl() }}" alt="{{ $concern->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-primary-subtle rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="ti ti-alert-circle text-primary" style="font-size: 2rem;"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $concern->name }}</h5>
                                <span class="badge bg-{{ $concern->type == 'skin' ? 'success' : 'info' }}-subtle text-{{ $concern->type == 'skin' ? 'success' : 'info' }}">
                                    {{ ucfirst($concern->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($concern->details)
                        <p class="text-muted fs-sm mb-3">{{ Str::limit($concern->details, 100) }}</p>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="ti ti-users fs-sm me-1"></i>{{ $concern->clients->count() }} Clients
                        </small>
                        <div class="d-flex gap-1">
                            <button class="btn btn-light btn-sm" onclick="editConcern({{ $concern->id }})" title="Edit">
                                <i class="ti ti-edit"></i>
                            </button>
                            <button class="btn btn-danger-subtle btn-sm text-danger" onclick="deleteConcern({{ $concern->id }}, '{{ $concern->name }}')" title="Delete">
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
                <div class="card-body text-center py-5">
                    <i class="ti ti-alert-circle text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 mb-2">No Concerns Found</h5>
                    <p class="text-muted">Start by adding your first concern</p>
                    <button class="btn btn-primary mt-2" data-bs-toggle="offcanvas" data-bs-target="#addConcernOffCanvas">
                        <i class="ti ti-plus me-1"></i>Add New Concern
                    </button>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($concerns->hasPages())
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-2">
                    {{ $concerns->links() }}
                </div>
            </div>
        </div>
    </div>
@endif
