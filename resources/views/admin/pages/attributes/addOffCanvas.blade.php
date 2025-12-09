<div class="offcanvas offcanvas-end" tabindex="-1" id="addOffCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Add New Attribute</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.attributes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Attribute Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g., Color, Size">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <div class="form-check form-switch form-control-lg">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <hr class="my-3">

            <!-- Attribute Values Section -->
            <div class="mb-3">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <label class="mb-0 form-label">Attribute Values</label>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addValueField()">
                        <i class="ti ti-plus me-1"></i>Add Value
                    </button>
                </div>
                <small class="text-muted">Add one or more values for this attribute (e.g., Red, Blue, Green)</small>

                <div id="valuesContainer" class="mt-3">
                    <!-- Initial value field -->
                    <div class="mb-2 value-field-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="values[]" placeholder="Enter value name">
                            <button type="button" class="btn btn-outline-danger" onclick="removeValueField(this)" disabled>
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gap-2 mt-4 d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Add Attribute
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    let valueFieldCount = 1;

    function addValueField() {
        valueFieldCount++;
        const container = document.getElementById('valuesContainer');
        const newField = document.createElement('div');
        newField.className = 'value-field-group mb-2';
        newField.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control" name="values[]" placeholder="Enter value name">
                <button type="button" class="btn btn-outline-danger" onclick="removeValueField(this)">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newField);
        updateRemoveButtons();
    }

    function removeValueField(button) {
        const fieldGroup = button.closest('.value-field-group');
        fieldGroup.remove();
        valueFieldCount--;
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('#valuesContainer .btn-outline-danger');
        removeButtons.forEach((btn, index) => {
            if (removeButtons.length === 1) {
                btn.disabled = true;
            } else {
                btn.disabled = false;
            }
        });
    }

    // Reset form when offcanvas is closed
    document.getElementById('addOffCanvas').addEventListener('hidden.bs.offcanvas', function () {
        const container = document.getElementById('valuesContainer');
        container.innerHTML = `
            <div class="mb-2 value-field-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="values[]" placeholder="Enter value name">
                    <button type="button" class="btn btn-outline-danger" onclick="removeValueField(this)" disabled>
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `;
        valueFieldCount = 1;
    });
</script>
