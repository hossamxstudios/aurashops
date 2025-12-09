<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.settings.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="category" required placeholder="e.g. general, email, payment">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="type" required>
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
                        <input type="text" class="form-control" name="key" required placeholder="e.g. site_name, smtp_host">
                        <small class="text-muted">Unique identifier for this setting</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <textarea class="form-control" name="value" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Details</label>
                        <textarea class="form-control" name="details" rows="2" placeholder="Description or notes about this setting"></textarea>
                    </div>

                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_public" id="is_public" checked>
                            <label class="form-check-label" for="is_public">Public (visible to frontend)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
