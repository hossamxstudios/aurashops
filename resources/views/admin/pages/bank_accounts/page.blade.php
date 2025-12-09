<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <span class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" type="button" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> Add Bank Account
        </span>
        <h3 class="fw-bold">
            Bank Accounts
        </h3>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Search Filter -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i data-lucide="search" class="icon-sm"></i></span>
                                <input type="text" id="searchBankAccounts" class="form-control" placeholder="Search by name, bank, or account number...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-centered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                                <th>IBAN</th>
                                <th>Currency</th>
                                <th>Status</th>
                                <th width="100">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="bankAccountsTableBody">
                            @forelse($bankAccounts as $account)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <span class="fw-bold">{{ $account->name }}</span>
                                                @if($account->is_default)
                                                    <span class="badge bg-success ms-2">Default</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $account->bank_name }}</td>
                                    <td>
                                        @if($account->account_number)
                                            <code class="small">{{ $account->account_number }}</code>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($account->iban)
                                            <code class="small">{{ $account->iban }}</code>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $account->currency }}</span>
                                    </td>
                                    <td>
                                        @if($account->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light" onclick="editBankAccount({{ $account->id }})" title="Edit">
                                            <i data-lucide="edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBankAccount({{ $account->id }}, '{{ $account->name }}')" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center">
                                        <p class="mb-0 text-muted">No bank accounts found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $bankAccounts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.pages.bank_accounts.createModal')
@include('admin.pages.bank_accounts.editModal')
@include('admin.pages.bank_accounts.deleteModal')

<script>
    // Re-initialize Lucide icons after page load
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Search/Filter bank accounts table
    document.getElementById('searchBankAccounts').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableBody = document.getElementById('bankAccountsTableBody');
        const rows = tableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const name = row.cells[0]?.textContent.toLowerCase() || '';
            const bankName = row.cells[1]?.textContent.toLowerCase() || '';
            const accountNumber = row.cells[2]?.textContent.toLowerCase() || '';

            if (name.includes(searchTerm) || bankName.includes(searchTerm) || accountNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
