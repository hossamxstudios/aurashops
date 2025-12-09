<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning" id="blockModalLabel">
                    <i class="ti ti-ban me-2"></i>Confirm {{ $client->is_blocked ? 'Unblock' : 'Block' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="avatar-xl mx-auto mb-3">
                        <div class="avatar-title bg-warning-subtle text-warning rounded-circle">
                            <i class="ti ti-ban fs-1"></i>
                        </div>
                    </div>
                    <h4 class="mb-2">{{ $client->is_blocked ? 'Unblock' : 'Block' }} Client?</h4>
                    <p class="text-muted mb-0">Do you want to {{ $client->is_blocked ? 'unblock' : 'block' }} <strong>{{ $client->full_name }}</strong>?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.clients.block', $client->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-{{ $client->is_blocked ? 'success' : 'warning' }}">
                        <i class="ti ti-ban me-1"></i>{{ $client->is_blocked ? 'Unblock' : 'Block' }} Client
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
