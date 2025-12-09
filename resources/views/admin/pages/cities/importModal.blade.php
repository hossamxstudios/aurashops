<div class="modal fade" id="importJsonModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="importJsonForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i data-lucide="upload" class="me-2"></i>Import Locations from JSON</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i data-lucide="info" class="me-2"></i>
                        <strong>Instructions:</strong> Paste your JSON data below. The JSON should contain cities, zones, and districts data in the correct format.
                    </div>

                    <div class="mb-3">
                        <label for="jsonData" class="form-label">JSON Data <span class="text-danger">*</span></label>
                        <textarea class="form-control font-monospace" id="jsonData" name="jsonData" rows="15" required placeholder='{"success": true, "data": [...]}'></textarea>
                        <small class="text-muted">Paste your complete JSON response here</small>
                    </div>

                    <div id="importProgress" class="d-none">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                        </div>
                        <p class="text-center mt-2 mb-0">Importing data...</p>
                    </div>

                    <div id="importResult" class="d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="importBtn">
                        <i data-lucide="upload" class="me-1"></i>Import Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('importJsonForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const jsonData = document.getElementById('jsonData').value;
        const importBtn = document.getElementById('importBtn');
        const progress = document.getElementById('importProgress');
        const result = document.getElementById('importResult');
        
        // Validate JSON
        try {
            JSON.parse(jsonData);
        } catch (e) {
            result.className = 'alert alert-danger';
            result.innerHTML = '<i data-lucide="x-circle" class="me-2"></i><strong>Error:</strong> Invalid JSON format. Please check your data.';
            result.classList.remove('d-none');
            return;
        }
        
        // Show progress
        importBtn.disabled = true;
        progress.classList.remove('d-none');
        result.classList.add('d-none');
        
        // Send request
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        fetch('/admin/locations/import-json', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '{{ csrf_token() }}'
            },
            body: JSON.stringify({ jsonData: jsonData })
        })
        .then(response => response.json())
        .then(data => {
            progress.classList.add('d-none');
            importBtn.disabled = false;
            
            if (data.success) {
                result.className = 'alert alert-success';
                result.innerHTML = `
                    <i data-lucide="check-circle" class="me-2"></i>
                    <strong>Success!</strong> Import completed successfully.<br>
                    <small>
                        Cities: ${data.stats.cities} | 
                        Zones: ${data.stats.zones} | 
                        Districts: ${data.stats.districts}
                    </small>
                `;
                result.classList.remove('d-none');
                
                // Reload page after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                result.className = 'alert alert-danger';
                result.innerHTML = `<i data-lucide="x-circle" class="me-2"></i><strong>Error:</strong> ${data.message}`;
                result.classList.remove('d-none');
            }
            
            // Re-initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        })
        .catch(error => {
            progress.classList.add('d-none');
            importBtn.disabled = false;
            result.className = 'alert alert-danger';
            result.innerHTML = `<i data-lucide="x-circle" class="me-2"></i><strong>Error:</strong> ${error.message}`;
            result.classList.remove('d-none');
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    });
</script>
