<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Pickup Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this pickup location?</p>
                    <p class="fw-bold text-danger" id="delete_location_type"></p>
                    <div class="alert alert-warning">
                        <i data-lucide="alert-triangle" class="me-2"></i>
                        <strong>Warning:</strong> Make sure no orders are associated with this pickup location before deleting.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteLocation(id, type) {
        document.getElementById('deleteForm').action = `/admin/pickup-locations/${id}`;
        document.getElementById('delete_location_type').textContent = `${type} Pickup Location`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
        
        // Re-initialize icons in modal
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
</script>
