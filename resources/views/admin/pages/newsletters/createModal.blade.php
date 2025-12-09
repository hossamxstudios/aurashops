<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.newsletters.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Newsletter Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger" id="email_required_star">*</span></label>
                        <input type="email" class="form-control" name="email" id="create_email" required placeholder="example@email.com">
                        <small class="text-muted d-none" id="email_optional_note">Email is optional when client is selected</small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Client <small class="text-muted">(optional - link to existing client)</small></label>
                        <select class="form-select" name="client_id" id="create_client_id">
                            <option value="">None - Guest Subscription</option>
                            @foreach(\App\Models\Client::orderBy('email')->get() as $client)
                                <option value="{{ $client->id }}" data-email="{{ $client->email }}">{{ $client->full_name }} - {{ $client->email }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Subscription</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clientSelect = document.getElementById('create_client_id');
        const emailInput = document.getElementById('create_email');
        const requiredStar = document.getElementById('email_required_star');
        const optionalNote = document.getElementById('email_optional_note');
        const createModal = document.getElementById('createModal');

        if (clientSelect && emailInput) {
            clientSelect.addEventListener('change', function() {
                if (this.value) {
                    // Client selected - make email optional and auto-fill
                    emailInput.removeAttribute('required');
                    requiredStar.classList.add('d-none');
                    optionalNote.classList.remove('d-none');
                    
                    // Auto-fill email from selected client
                    const selectedOption = this.options[this.selectedIndex];
                    const clientEmail = selectedOption.getAttribute('data-email');
                    if (clientEmail) {
                        emailInput.value = clientEmail;
                    }
                } else {
                    // Guest subscription - make email required
                    emailInput.setAttribute('required', 'required');
                    requiredStar.classList.remove('d-none');
                    optionalNote.classList.add('d-none');
                    emailInput.value = '';
                }
            });
            
            // Reset form when modal is closed
            if (createModal) {
                createModal.addEventListener('hidden.bs.modal', function() {
                    emailInput.value = '';
                    clientSelect.value = '';
                    emailInput.setAttribute('required', 'required');
                    requiredStar.classList.remove('d-none');
                    optionalNote.classList.add('d-none');
                });
            }
        }
    });
</script>
