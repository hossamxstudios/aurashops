<div class="modal fade" id="manageConcernsModal" tabindex="-1" aria-labelledby="manageConcernsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageConcernsModalLabel">
                    <i class="ti ti-alert-circle me-2"></i>Manage Concerns
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.clients.update-concerns', $client->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted mb-4">Select the concerns that apply to this client</p>
                    
                    @php
                        $allConcerns = \App\Models\Concern::all();
                        $clientConcernIds = $client->concerns->pluck('id')->toArray();
                    @endphp
                    
                    @if($allConcerns->count() > 0)
                        <!-- Skin Concerns -->
                        @php
                            $skinConcerns = $allConcerns->where('type', 'skin');
                        @endphp
                        @if($skinConcerns->count() > 0)
                            <div class="mb-4">
                                <h6 class="mb-3">
                                    <i class="ti ti-droplet me-2 text-success"></i>Skin Concerns
                                </h6>
                                <div class="row g-3">
                                    @foreach($skinConcerns as $concern)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="concerns[]" value="{{ $concern->id }}" id="concern_{{ $concern->id }}" {{ in_array($concern->id, $clientConcernIds) ? 'checked' : '' }}>
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100" for="concern_{{ $concern->id }}">
                                                    @if($concern->getMedia('concern_image')->first())
                                                        <img src="{{ $concern->getMedia('concern_image')->first()->getUrl() }}" alt="{{ $concern->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-success-subtle rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="ti ti-alert-circle text-success"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold">{{ $concern->name }}</div>
                                                        @if($concern->details)
                                                            <small class="text-muted">{{ Str::limit($concern->details, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Hair Concerns -->
                        @php
                            $hairConcerns = $allConcerns->where('type', 'hair');
                        @endphp
                        @if($hairConcerns->count() > 0)
                            <div class="mb-3">
                                <h6 class="mb-3">
                                    <i class="ti ti-brush me-2 text-info"></i>Hair Concerns
                                </h6>
                                <div class="row g-3">
                                    @foreach($hairConcerns as $concern)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="concerns[]" value="{{ $concern->id }}" id="concern_{{ $concern->id }}" {{ in_array($concern->id, $clientConcernIds) ? 'checked' : '' }}>
                                                <label class="form-check-label d-flex align-items-center gap-2 w-100" for="concern_{{ $concern->id }}">
                                                    @if($concern->getMedia('concern_image')->first())
                                                        <img src="{{ $concern->getMedia('concern_image')->first()->getUrl() }}" alt="{{ $concern->name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-info-subtle rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="ti ti-alert-circle text-info"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <div class="fw-semibold">{{ $concern->name }}</div>
                                                        @if($concern->details)
                                                            <small class="text-muted">{{ Str::limit($concern->details, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>No concerns available. Please add concerns from the Concerns management page first.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
