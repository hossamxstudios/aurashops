<div class="modal fade" id="editCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCityForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-edit me-2"></i>Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_cityId" class="form-label">City ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_cityId" name="cityId" required placeholder="e.g., CAI">
                    </div>

                    <div class="mb-3">
                        <label for="edit_cityName" class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_cityName" name="cityName" required placeholder="e.g., Cairo">
                    </div>

                    <div class="mb-3">
                        <label for="edit_cityOtherName" class="form-label">City Other Name</label>
                        <input type="text" class="form-control" id="edit_cityOtherName" name="cityOtherName" placeholder="Alternative name">
                    </div>

                    <div class="mb-3">
                        <label for="edit_cityCode" class="form-label">City Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_cityCode" name="cityCode" required placeholder="e.g., 02">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Update City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editCity(id, cityId, cityName, cityOtherName, cityCode) {
        document.getElementById('edit_cityId').value = cityId;
        document.getElementById('edit_cityName').value = cityName;
        document.getElementById('edit_cityOtherName').value = cityOtherName || '';
        document.getElementById('edit_cityCode').value = cityCode;
        document.getElementById('editCityForm').action = `/admin/cities/${id}`;
        
        const modal = new bootstrap.Modal(document.getElementById('editCityModal'));
        modal.show();
    }
</script>
