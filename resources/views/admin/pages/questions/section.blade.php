{{-- Questions Section - to be included in product pages --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i data-lucide="help-circle" class="icon-sm me-1"></i>
            Frequently Asked Questions
            <span class="badge bg-secondary">{{ $product->questions->count() }}</span>
        </h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
            <i data-lucide="plus" class="icon-sm me-1"></i> Add Question
        </button>
    </div>
    <div class="card-body">
        @forelse($product->questions as $question)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-2">
                            <i data-lucide="message-circle-question" class="icon-sm me-1 text-primary"></i>
                            {{ $question->question }}
                        </h6>
                        <p class="mb-1 ps-4">
                            <i data-lucide="message-circle-reply" class="icon-sm me-1 text-success"></i>
                            {{ $question->answer }}
                        </p>
                        <small class="text-muted ps-4">{{ $question->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="btn-group btn-group-sm ms-2">
                        <button class="btn btn-outline-primary" onclick="editQuestion({{ $question->id }})" title="Edit">
                            <i data-lucide="edit" class="icon-xs"></i>
                        </button>
                        <button class="btn btn-outline-danger" onclick="deleteQuestion({{ $question->id }})" title="Delete">
                            <i data-lucide="trash-2" class="icon-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i data-lucide="help-circle" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                <p class="mb-0">No questions yet</p>
            </div>
        @endforelse
    </div>
</div>

@include('admin.pages.questions.addModal')
@include('admin.pages.questions.editModal')
@include('admin.pages.questions.deleteModal')

<script>
    function editQuestion(id) {
        fetch(`/admin/questions/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editQuestionForm').action = `/admin/questions/${id}`;
                document.getElementById('edit_question_text').value = data.question;
                document.getElementById('edit_question_answer').value = data.answer;
                
                new bootstrap.Modal(document.getElementById('editQuestionModal')).show();
            });
    }

    function deleteQuestion(id) {
        document.getElementById('deleteQuestionForm').action = `/admin/questions/${id}`;
        new bootstrap.Modal(document.getElementById('deleteQuestionModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
