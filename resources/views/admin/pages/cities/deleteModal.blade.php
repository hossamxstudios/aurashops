<div class="modal fade" id="deleteCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteCityForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Delete City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteCityName"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-circle me-2"></i>
                        This action cannot be undone. The city can only be deleted if it has no zones or addresses.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>Delete City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteCity(id, cityName) {
        document.getElementById('deleteCityName').textContent = cityName;
        document.getElementById('deleteCityForm').action = `/admin/cities/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteCityModal'));
        modal.show();
    }
</script>
