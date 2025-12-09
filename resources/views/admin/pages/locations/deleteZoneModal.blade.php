<div class="modal fade" id="deleteZoneModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteZoneForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i data-lucide="alert-triangle" class="me-2"></i>Delete Zone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteZoneName"></strong>?</p>
                    <div class="alert alert-warning">
                        <i data-lucide="alert-circle" class="me-2"></i>
                        This will also delete all districts in this zone. This action cannot be undone.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i data-lucide="trash" class="me-1"></i>Delete Zone
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentCityIdForZoneDelete = null;

    function deleteZoneInCity(zoneId, zoneName, cityId) {
        currentCityIdForZoneDelete = cityId;
        
        document.getElementById('deleteZoneName').textContent = zoneName;
        document.getElementById('deleteZoneForm').action = `/admin/locations/zones/${zoneId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteZoneModal'));
        modal.show();
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    document.getElementById('deleteZoneForm').addEventListener('submit', function(e) {
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
                bootstrap.Modal.getInstance(document.getElementById('deleteZoneModal')).hide();
                // Reload the page to show updates
                window.location.reload();
            } else {
                alert(data.message || 'Failed to delete zone');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete zone');
        });
    });
</script>
