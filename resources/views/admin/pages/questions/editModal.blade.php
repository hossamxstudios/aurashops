<div class="modal fade" id="editQuestionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editQuestionForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Question & Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="question" id="edit_question_text" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Answer <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="answer" id="edit_question_answer" rows="4" required></textarea>
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
