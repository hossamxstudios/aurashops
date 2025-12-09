<div class="modal fade" id="editReviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editReviewForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <select class="form-select" name="rating" id="edit_review_rating" required>
                            <option value="5">★★★★★ (5 stars)</option>
                            <option value="4">★★★★☆ (4 stars)</option>
                            <option value="3">★★★☆☆ (3 stars)</option>
                            <option value="2">★★☆☆☆ (2 stars)</option>
                            <option value="1">★☆☆☆☆ (1 star)</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" name="comment" id="edit_review_comment" rows="4"></textarea>
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
