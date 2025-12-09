<div class="modal fade" id="addQuestionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.questions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add Question & Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="question" required placeholder="What is your question?">
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Answer <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="answer" rows="4" required placeholder="Provide the answer..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Q&A</button>
                </div>
            </form>
        </div>
    </div>
</div>
