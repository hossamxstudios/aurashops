<div class="offcanvas offcanvas-end" tabindex="-1" id="editOffCanvas" style="width: 600px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Edit Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editClientForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="edit_first_name" name="first_name" required>
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="edit_last_name" name="last_name" required>
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="edit_email" name="email" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="edit_phone" name="phone">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_gender" class="form-label">Gender</label>
                <select class="form-select @error('gender') is-invalid @enderror" id="edit_gender" name="gender">
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="edit_birthdate" name="birthdate">
                @error('birthdate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_referred_by_id" class="form-label">Referred By</label>
                <select class="form-control @error('referred_by_id') is-invalid @enderror" id="edit_referred_by_id" name="referred_by_id" data-choices data-choices-search-true data-choices-removeItem>
                   <option value="">-- None --</option>
                    @foreach(\App\Models\Client::all() as $client)
                        <option value="{{ $client->id }}">
                            {{ $client->full_name }}
                        </option>
                    @endforeach
                </select>
                @error('referred_by_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="gap-2 d-grid">
                <button type="submit" class="btn btn-primary">Update Client</button>
                <button type="button" class="btn btn-danger-subtle" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editClient(clientId) {
        // Fetch client data
        fetch(`/admin/clients/${clientId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Update form action
                document.getElementById('editClientForm').action = `/admin/clients/${clientId}`;

                // Fill form fields
                document.getElementById('edit_first_name').value = data.first_name || '';
                document.getElementById('edit_last_name').value = data.last_name || '';
                document.getElementById('edit_email').value = data.email || '';
                document.getElementById('edit_phone').value = data.phone || '';
                document.getElementById('edit_gender').value = data.gender || '';
                document.getElementById('edit_birthdate').value = data.birthdate || '';

                // Update Choices.js select for referred_by_id
                const referredBySelect = document.getElementById('edit_referred_by_id');
                if (referredBySelect && referredBySelect.choicesInstance) {
                    referredBySelect.choicesInstance.setChoiceByValue(data.referred_by_id || '');
                } else {
                    referredBySelect.value = data.referred_by_id || '';
                }

                // Show offcanvas
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('editOffCanvas'));
                offcanvas.show();
            })
            .catch(error => console.error('Error:', error));
    }
</script>
