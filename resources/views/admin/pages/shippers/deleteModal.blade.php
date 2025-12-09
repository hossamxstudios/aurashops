<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Shipper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this shipper?</p>
                    <p class="fw-bold text-danger" id="delete_shipper_name"></p>
                    <div class="alert alert-warning">
                        <i data-lucide="alert-triangle" class="me-2"></i>
                        <strong>Warning:</strong> You cannot delete shippers that have existing shipping rates.
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
    function deleteShipper(id, name) {
        document.getElementById('deleteForm').action = `/admin/shippers/${id}`;
        document.getElementById('delete_shipper_name').textContent = name;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
        
        // Re-initialize icons in modal
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
</script>
