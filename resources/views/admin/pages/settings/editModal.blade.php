<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category" id="edit_category" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" id="edit_type" required>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="number">Number</option>
                            <option value="boolean">Boolean</option>
                            <option value="url">URL</option>
                            <option value="email">Email</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Key <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="key" id="edit_key" required>
                        <small class="text-muted">Unique identifier for this setting</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <textarea class="form-control" name="value" id="edit_value" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Details</label>
                        <textarea class="form-control" name="details" id="edit_details" rows="2"></textarea>
                    </div>

                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_public" id="edit_is_public">
                            <label class="form-check-label" for="edit_is_public">Public (visible to frontend)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
