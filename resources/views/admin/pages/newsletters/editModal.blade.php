<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Newsletter Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger" id="edit_email_required_star">*</span></label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                        <small class="text-muted d-none" id="edit_email_optional_note">Email is optional when client is selected</small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Client <small class="text-muted">(optional)</small></label>
                        <select class="form-select" name="client_id" id="edit_client_id">
                            <option value="">None - Guest Subscription</option>
                            @foreach(\App\Models\Client::orderBy('email')->get() as $client)
                                <option value="{{ $client->id }}" data-email="{{ $client->email }}">{{ $client->full_name }} - {{ $client->email }}</option>
                            @endforeach
                        </select>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editClientSelect = document.getElementById('edit_client_id');
        const editEmailInput = document.getElementById('edit_email');
        const editRequiredStar = document.getElementById('edit_email_required_star');
        const editOptionalNote = document.getElementById('edit_email_optional_note');

        if (editClientSelect && editEmailInput) {
            editClientSelect.addEventListener('change', function() {
                if (this.value) {
                    // Client selected - make email optional and auto-fill
                    editEmailInput.removeAttribute('required');
                    editRequiredStar.classList.add('d-none');
                    editOptionalNote.classList.remove('d-none');
                    
                    // Auto-fill email from selected client
                    const selectedOption = this.options[this.selectedIndex];
                    const clientEmail = selectedOption.getAttribute('data-email');
                    if (clientEmail) {
                        editEmailInput.value = clientEmail;
                    }
                } else {
                    // Guest subscription - make email required
                    editEmailInput.setAttribute('required', 'required');
                    editRequiredStar.classList.remove('d-none');
                    editOptionalNote.classList.add('d-none');
                }
            });
        }
    });
</script>
