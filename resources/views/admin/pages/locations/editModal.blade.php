<div class="modal fade" id="editCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCityForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="edit" class="me-2"></i>Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_cityId" class="form-label">City ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_cityId" name="cityId" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_cityName" class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_cityName" name="cityName" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_cityOtherName" class="form-label">Other Name</label>
                        <input type="text" class="form-control" id="edit_cityOtherName" name="cityOtherName">
                    </div>

                    <div class="mb-3">
                        <label for="edit_cityCode" class="form-label">City Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_cityCode" name="cityCode" required>
                    </div>

                    <div class="alert alert-info">
                        <small><i data-lucide="info"></i> To manage zones and districts, please view the city details</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check" class="me-1"></i>Update City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editCity(id) {
        fetch(`/admin/locations/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_cityId').value = data.cityId;
                document.getElementById('edit_cityName').value = data.cityName;
                document.getElementById('edit_cityOtherName').value = data.cityOtherName || '';
                document.getElementById('edit_cityCode').value = data.cityCode;
                document.getElementById('editCityForm').action = `/admin/locations/${id}`;
                
                const modal = new bootstrap.Modal(document.getElementById('editCityModal'));
                modal.show();
                
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load city data');
            });
    }
</script>
