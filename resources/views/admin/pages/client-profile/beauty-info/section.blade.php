<div class="row g-3">
    <!-- Skin Tone Card -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-palette me-2"></i>Skin Tone</h6>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#skinProfileModal" title="Edit">
                    <i class="ti ti-edit"></i>
                </button>
            </div>
            <div class="card-body">
                @if($client->skinTone)
                    <div class="text-center">
                        @if($client->skinTone->getMedia('skin_tone_image')->first())
                            <img src="{{ $client->skinTone->getMedia('skin_tone_image')->first()->getUrl() }}" alt="{{ $client->skinTone->name }}" class="rounded mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-primary-subtle rounded mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="ti ti-palette text-primary fs-1"></i>
                            </div>
                        @endif
                        <h5 class="mb-2">{{ $client->skinTone->name }}</h5>
                        @if($client->skinTone->details)
                            <p class="text-muted fs-sm">{{ $client->skinTone->details }}</p>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-palette text-muted" style="font-size: 3rem; opacity: 0.2;"></i>
                        <p class="text-muted mt-3 mb-0">No skin tone set</p>
                        <button class="btn btn-primary-subtle btn-sm text-primary mt-2" data-bs-toggle="modal" data-bs-target="#skinProfileModal">
                            <i class="ti ti-plus me-1"></i>Set Skin Tone
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Skin Type Card -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-droplet me-2"></i>Skin Type</h6>
                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#skinProfileModal" title="Edit">
                    <i class="ti ti-edit"></i>
                </button>
            </div>
            <div class="card-body">
                @if($client->skinType)
                    <div class="text-center">
                        @if($client->skinType->getMedia('skin_type_image')->first())
                            <img src="{{ $client->skinType->getMedia('skin_type_image')->first()->getUrl() }}" alt="{{ $client->skinType->name }}" class="rounded mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-success-subtle rounded mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="ti ti-droplet text-success fs-1"></i>
                            </div>
                        @endif
                        <h5 class="mb-2">{{ $client->skinType->name }}</h5>
                        @if($client->skinType->details)
                            <p class="text-muted fs-sm">{{ $client->skinType->details }}</p>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-droplet text-muted" style="font-size: 3rem; opacity: 0.2;"></i>
                        <p class="text-muted mt-3 mb-0">No skin type set</p>
                        <button class="btn btn-primary-subtle btn-sm text-primary mt-2" data-bs-toggle="modal" data-bs-target="#skinProfileModal">
                            <i class="ti ti-plus me-1"></i>Set Skin Type
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Concerns Card -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-alert-circle me-2"></i>Concerns</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#manageConcernsModal" title="Manage Concerns">
                    <i class="ti ti-settings"></i>
                </button>
            </div>
            <div class="card-body">
                @if($client->concerns->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($client->concerns as $concern)
                            <div class="border rounded p-2 d-flex align-items-center gap-2" style="background-color: #f8f9fa;">
                                @if($concern->getMedia('concern_image')->first())
                                    <img src="{{ $concern->getMedia('concern_image')->first()->getUrl() }}" alt="{{ $concern->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-primary-subtle rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="ti ti-alert-circle text-primary"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <div class="fw-semibold fs-sm">{{ $concern->name }}</div>
                                    <span class="badge bg-{{ $concern->type == 'skin' ? 'success' : 'info' }}-subtle text-{{ $concern->type == 'skin' ? 'success' : 'info' }} fs-xs">
                                        {{ ucfirst($concern->type) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-alert-circle text-muted" style="font-size: 3rem; opacity: 0.2;"></i>
                        <p class="text-muted mt-3 mb-0">No concerns added</p>
                        <button class="btn btn-primary-subtle btn-sm text-primary mt-2" data-bs-toggle="modal" data-bs-target="#manageConcernsModal">
                            <i class="ti ti-plus me-1"></i>Add Concerns
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
