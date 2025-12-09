<div class="offcanvas offcanvas-end" tabindex="-1" id="editOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Edit Attribute</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editAttributeForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="edit_name" class="form-label">Attribute Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_name" name="name" required placeholder="e.g., Color, Size">
            </div>

            <div class="mb-3">
                <label for="edit_is_active" class="form-label">Status</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                    <label class="form-check-label" for="edit_is_active">Active</label>
                </div>
            </div>

            <hr class="my-3">

            <!-- Attribute Values Section -->
            <div class="mb-3">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <label class="mb-0 form-label">Attribute Values</label>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addEditValueField()">
                        <i class="ti ti-plus me-1"></i>Add Value
                    </button>
                </div>
                <small class="text-muted">Add or update values for this attribute</small>

                <div id="editValuesContainer" class="mt-3">
                    <!-- Values will be loaded dynamically -->
                </div>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Update Attribute
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    let editValueFieldCount = 0;

    function editAttribute(attributeId) {
        // Fetch attribute data
        fetch(`/admin/attributes/${attributeId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form fields
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_is_active').checked = data.is_active == 1;

                // Clear and populate values
                const container = document.getElementById('editValuesContainer');
                container.innerHTML = '';
                editValueFieldCount = 0;

                // Load existing values
                if (data.values && data.values.length > 0) {
                    data.values.forEach(value => {
                        addEditValueField(value.id, value.name);
                    });
                } else {
                    // Add one empty field if no values exist
                    addEditValueField();
                }

                // Set form action
                document.getElementById('editAttributeForm').action = `/admin/attributes/${attributeId}`;

                // Show offcanvas
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('editOffCanvas'));
                offcanvas.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load attribute data');
            });
    }

    function addEditValueField(valueId = null, valueName = '') {
        editValueFieldCount++;
        const container = document.getElementById('editValuesContainer');
        const newField = document.createElement('div');
        newField.className = 'value-field-group mb-2';

        const valueIdInput = valueId ? `<input type="hidden" name="value_ids[]" value="${valueId}">` : '<input type="hidden" name="value_ids[]" value="">';

        newField.innerHTML = `
            <div class="input-group">
                ${valueIdInput}
                <input type="text" class="form-control" name="values[]" placeholder="Enter value name" value="${valueName}">
                <button type="button" class="btn btn-outline-danger" onclick="removeEditValueField(this)">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newField);
        updateEditRemoveButtons();
    }

    function removeEditValueField(button) {
        const fieldGroup = button.closest('.value-field-group');
        fieldGroup.remove();
        editValueFieldCount--;
        updateEditRemoveButtons();
    }

    function updateEditRemoveButtons() {
        const removeButtons = document.querySelectorAll('#editValuesContainer .btn-outline-danger');
        removeButtons.forEach((btn, index) => {
            if (removeButtons.length === 1) {
                btn.disabled = true;
            } else {
                btn.disabled = false;
            }
        });
    }
</script>
