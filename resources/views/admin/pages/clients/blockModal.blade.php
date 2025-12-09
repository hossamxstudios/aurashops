<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning" id="blockModalLabel">
                    <i class="ti ti-ban me-2"></i>Confirm Block/Unblock
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
                    <h4 class="mb-2" id="blockModalTitle">Are you sure?</h4>
                    <p class="text-muted mb-0" id="blockModalMessage"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="blockClientForm" method="POST" style="display: inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-warning" id="blockModalButton">
                        <i class="ti ti-ban me-1"></i>Block Client
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function blockClient(clientId, clientName, isBlocked) {
        // Update modal content based on current status
        const action = isBlocked ? 'unblock' : 'block';
        const actionTitle = isBlocked ? 'Unblock' : 'Block';
        
        document.getElementById('blockModalTitle').textContent = `${actionTitle} Client?`;
        document.getElementById('blockModalMessage').innerHTML = `Do you want to ${action} <strong>${clientName}</strong>?`;
        document.getElementById('blockModalButton').innerHTML = `<i class="ti ti-ban me-1"></i>${actionTitle} Client`;
        document.getElementById('blockModalButton').className = isBlocked ? 'btn btn-success' : 'btn btn-warning';
        
        // Update form action
        document.getElementById('blockClientForm').action = `/admin/clients/${clientId}/block`;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('blockModal'));
        modal.show();
    }
</script>
