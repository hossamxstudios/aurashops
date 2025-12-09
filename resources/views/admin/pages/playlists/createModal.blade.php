<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.playlists.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required placeholder="e.g. Makeup Tutorials">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug <small class="text-muted">(leave empty for auto-generate)</small></label>
                        <input type="text" class="form-control" name="slug" placeholder="e.g. makeup-tutorials">
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Details</label>
                        <textarea class="form-control" name="details" rows="3" placeholder="Playlist description..."></textarea>
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
