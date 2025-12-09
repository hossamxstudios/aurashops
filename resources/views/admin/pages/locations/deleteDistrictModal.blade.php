<div class="modal fade" id="deleteDistrictModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteDistrictForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i data-lucide="alert-triangle" class="me-2"></i>Delete District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteDistrictName"></strong>?</p>
                    <div class="alert alert-warning">
                        <i data-lucide="alert-circle" class="me-2"></i>
                        This action cannot be undone. The district can only be deleted if it has no addresses.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i data-lucide="trash" class="me-1"></i>Delete District
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentCityIdForDistrictDelete = null;

    function deleteDistrictInCity(districtId, districtName, cityId) {
        currentCityIdForDistrictDelete = cityId;
        
        document.getElementById('deleteDistrictName').textContent = districtName;
        document.getElementById('deleteDistrictForm').action = `/admin/locations/districts/${districtId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteDistrictModal'));
        modal.show();
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    document.getElementById('deleteDistrictForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        fetch(this.action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('deleteDistrictModal')).hide();
                // Reload the page to show updates
                window.location.reload();
            } else {
                alert(data.message || 'Failed to delete district');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete district');
        });
    });
</script>
