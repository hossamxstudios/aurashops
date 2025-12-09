<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bank Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="edit_name" placeholder="e.g., Business Account" required>
                            <small class="text-muted">A friendly name to identify this account</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bank_name" id="edit_bank_name" placeholder="e.g., National Bank of Egypt" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" name="account_number" id="edit_account_number" placeholder="e.g., 1234567890">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">IBAN</label>
                            <input type="text" class="form-control" name="iban" id="edit_iban" placeholder="e.g., EG380019000500000000263180002">
                            <small class="text-muted">International Bank Account Number</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SWIFT/BIC Code</label>
                            <input type="text" class="form-control" name="swift_bic" id="edit_swift_bic" placeholder="e.g., NBEAEGCXXXX">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Currency <span class="text-danger">*</span></label>
                            <select class="form-select" name="currency" id="edit_currency" required>
                                <option value="EGP">EGP - Egyptian Pound</option>
                                <option value="USD">USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                                <option value="SAR">SAR - Saudi Riyal</option>
                                <option value="AED">AED - UAE Dirham</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_active" id="edit_is_active" value="1">
                                <label class="form-check-label" for="edit_is_active">
                                    Active
                                </label>
                            </div>
                            <small class="text-muted d-block">Account can be used for transactions</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_default" id="edit_is_default" value="1">
                                <label class="form-check-label" for="edit_is_default">
                                    Set as Default
                                </label>
                            </div>
                            <small class="text-muted d-block">Make this the default bank account</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editBankAccount(id) {
        fetch(`/admin/bank-accounts/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/bank-accounts/${id}`;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_bank_name').value = data.bank_name;
                document.getElementById('edit_account_number').value = data.account_number || '';
                document.getElementById('edit_iban').value = data.iban || '';
                document.getElementById('edit_swift_bic').value = data.swift_bic || '';
                document.getElementById('edit_currency').value = data.currency;
                document.getElementById('edit_is_active').checked = data.is_active;
                document.getElementById('edit_is_default').checked = data.is_default;

                const modal = new bootstrap.Modal(document.getElementById('editModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load bank account details');
            });
    }
</script>
