<div class="offcanvas offcanvas-end" tabindex="-1" id="editOffCanvas" style="width: 600px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Edit Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editClientForm" action="{{ route('admin.clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="edit_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="edit_first_name" name="first_name" required value="{{ $client->first_name }}">
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="edit_last_name" name="last_name" required value="{{ $client->last_name }}">
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="edit_email" name="email" required value="{{ $client->email }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="edit_phone" name="phone" value="{{ $client->phone }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_gender" class="form-label">Gender</label>
                <select class="form-select @error('gender') is-invalid @enderror" id="edit_gender" name="gender" >
                    <option value="">-- Select Gender --</option>
                    <option value="Male" {{ $client->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $client->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="edit_birthdate" name="birthdate" value="{{ $client->birthdate }}">
                @error('birthdate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="edit_referred_by_id" class="form-label">Referred By</label>
                <select class="form-control @error('referred_by_id') is-invalid @enderror" id="edit_referred_by_id" name="referred_by_id" data-choices data-choices-search-true data-choices-removeItem>
                   <option value="">-- None --</option>
                    @foreach(\App\Models\Client::all() as $referrer)
                        <option value="{{ $referrer->id }}" {{ $client->referred_by_id == $referrer->id ? 'selected' : '' }}>
                            {{ $referrer->full_name }}
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
