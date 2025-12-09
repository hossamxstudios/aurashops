<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Bank Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="e.g., Business Account" required>
                            <small class="text-muted">A friendly name to identify this account</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bank_name" placeholder="e.g., National Bank of Egypt" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" name="account_number" placeholder="e.g., 1234567890">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">IBAN</label>
                            <input type="text" class="form-control" name="iban" placeholder="e.g., EG380019000500000000263180002">
                            <small class="text-muted">International Bank Account Number</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SWIFT/BIC Code</label>
                            <input type="text" class="form-control" name="swift_bic" placeholder="e.g., NBEAEGCXXXX">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Currency <span class="text-danger">*</span></label>
                            <select class="form-select" name="currency" required>
                                <option value="EGP" selected>EGP - Egyptian Pound</option>
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
                                <input type="checkbox" class="form-check-input" name="is_active" id="create_is_active" value="1" checked>
                                <label class="form-check-label" for="create_is_active">
                                    Active
                                </label>
                            </div>
                            <small class="text-muted d-block">Account can be used for transactions</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_default" id="create_is_default" value="1">
                                <label class="form-check-label" for="create_is_default">
                                    Set as Default
                                </label>
                            </div>
                            <small class="text-muted d-block">Make this the default bank account</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
