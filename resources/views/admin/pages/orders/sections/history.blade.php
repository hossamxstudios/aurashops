<div class="card mb-3">
    <div class="card-header bg-light">
        <h6 class="card-title mb-0">
            <i class="ti ti-history me-2"></i>
            Order History
        </h6>
    </div>
    <div class="card-body">
        @if($histories->isEmpty())
            <p class="text-muted mb-0">No history records yet.</p>
        @else
            <div class="order-timeline">
                @foreach($histories as $history)
                    <div class="timeline-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $history->name }}</strong>
                                @if($history->status)
                                    <span class="badge ms-2" style="background-color: {{ $history->status->color }};">
                                        {{ $history->status->name }}
                                    </span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $history->created_at->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
