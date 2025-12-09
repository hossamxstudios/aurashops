<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person</label>
                            <input type="text" class="form-control" name="contact_person" id="edit_contact_person">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email" class="form-control" name="contact_email" id="edit_contact_email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" name="contact_phone" id="edit_contact_phone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" id="edit_address" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control" name="website" id="edit_website">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Currency <span class="text-danger">*</span></label>
                            <select class="form-select" name="currency" id="edit_currency" required>
                                <option value="EGP">EGP</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Terms</label>
                        <input type="text" class="form-control" name="payment_terms" id="edit_payment_terms">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" id="edit_notes" rows="2"></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" id="edit_is_active" value="1">
                        <label class="form-check-label">Active</label>
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
    function editSupplier(id) {
        fetch(`/admin/suppliers/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/suppliers/${id}`;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_contact_person').value = data.contact_person || '';
                document.getElementById('edit_contact_email').value = data.contact_email || '';
                document.getElementById('edit_contact_phone').value = data.contact_phone || '';
                document.getElementById('edit_address').value = data.address || '';
                document.getElementById('edit_website').value = data.website || '';
                document.getElementById('edit_currency').value = data.currency;
                document.getElementById('edit_payment_terms').value = data.payment_terms || '';
                document.getElementById('edit_notes').value = data.notes || '';
                document.getElementById('edit_is_active').checked = data.is_active;
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
    }
</script>
