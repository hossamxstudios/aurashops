<div class="modal fade" id="skinProfileModal" tabindex="-1" aria-labelledby="skinProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="skinProfileModalLabel">
                    <i class="ti ti-user-cog me-2"></i>Update Skin Profile
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.clients.update-skin-profile', $client->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Skin Tone Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-palette me-1"></i>Select Skin Tone
                        </label>
                        <div class="row g-3">
                            @php
                                $skinTones = \App\Models\SkinTone::all();
                            @endphp
                            @forelse($skinTones as $tone)
                                <div class="col-md-4 col-sm-6">
                                    <input type="radio" class="btn-check" name="skin_tone_id" id="tone_{{ $tone->id }}" value="{{ $tone->id }}" {{ $client->skin_tone_id == $tone->id ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary w-100 p-3 d-flex flex-column align-items-center" for="tone_{{ $tone->id }}" style="height: 100%;">
                                        @if($tone->getMedia('skin_tone_image')->first())
                                            <img src="{{ $tone->getMedia('skin_tone_image')->first()->getUrl() }}" alt="{{ $tone->name }}" class="rounded mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary-subtle rounded mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="ti ti-palette text-primary fs-2"></i>
                                            </div>
                                        @endif
                                        <span class="fw-semibold">{{ $tone->name }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        <i class="ti ti-info-circle me-2"></i>No skin tones available. Please add them first.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <hr>

                    <!-- Skin Type Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-droplet me-1"></i>Select Skin Type
                        </label>
                        <div class="row g-3">
                            @php
                                $skinTypes = \App\Models\SkinType::all();
                            @endphp
                            @forelse($skinTypes as $type)
                                <div class="col-md-4 col-sm-6">
                                    <input type="radio" class="btn-check" name="skin_type_id" id="type_{{ $type->id }}" value="{{ $type->id }}" {{ $client->skin_type_id == $type->id ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success w-100 p-3 d-flex flex-column align-items-center" for="type_{{ $type->id }}" style="height: 100%;">
                                        @if($type->getMedia('skin_type_image')->first())
                                            <img src="{{ $type->getMedia('skin_type_image')->first()->getUrl() }}" alt="{{ $type->name }}" class="rounded mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-success-subtle rounded mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="ti ti-droplet text-success fs-2"></i>
                                            </div>
                                        @endif
                                        <span class="fw-semibold">{{ $type->name }}</span>
                                        @if($type->details)
                                            <small class="text-muted text-center mt-1" style="font-size: 10px;">{{ Str::limit($type->details, 30) }}</small>
                                        @endif
                                    </label>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        <i class="ti ti-info-circle me-2"></i>No skin types available. Please add them first.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Update Skin Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-check:checked + label {
        box-shadow: 0 0 0 3px rgba(var(--bs-primary-rgb), 0.25);
    }
</style>
