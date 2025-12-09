<div class="modal fade" id="deleteZoneModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteZoneForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Delete Zone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteZoneName"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-circle me-2"></i>
                        This action cannot be undone. The zone can only be deleted if it has no districts or addresses.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>Delete Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteZone(id, zoneName) {
        document.getElementById('deleteZoneName').textContent = zoneName;
        document.getElementById('deleteZoneForm').action = `/admin/zones/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteZoneModal'));
        modal.show();
    }
</script>
