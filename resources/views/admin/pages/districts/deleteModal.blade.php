<div class="modal fade" id="deleteDistrictModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteDistrictForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Delete District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteDistrictName"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-circle me-2"></i>
                        This action cannot be undone. The district can only be deleted if it has no addresses.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>Delete District
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteDistrict(id, districtName) {
        document.getElementById('deleteDistrictName').textContent = districtName;
        document.getElementById('deleteDistrictForm').action = `/admin/districts/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteDistrictModal'));
        modal.show();
    }
</script>
