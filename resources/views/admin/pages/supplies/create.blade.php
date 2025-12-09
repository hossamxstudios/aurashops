<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Create Supply Order</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="py-1 pt-4 row justify-content-between align-items-center">
                        <div class="col-auto">
                            <a href="{{ route('admin.supplies.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i data-lucide="arrow-left" class="icon-sm me-1"></i> Back
                            </a>
                        </div>
                        <div class="col-auto">
                            <h3 class="fw-bold mb-0">Create Supply Order</h3>
                        </div>
                        <div class="col-auto"></div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.supplies.store') }}" method="POST" id="supplyForm">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-8">
                                <!-- Supply Items -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title mb-0">
                                                <i data-lucide="package" class="icon-sm me-2"></i>Supply Items
                                            </h5>
                                            <button type="button" class="btn btn-success btn-sm" onclick="addItemRow()">
                                                <i data-lucide="plus" class="icon-sm me-1"></i> Add Item
                                            </button>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-sm" id="itemsTable">
                                                <thead>
                                                    <tr>
                                                        <th width="35%">Product</th>
                                                        <th width="25%">Variant</th>
                                                        <th width="12%">Qty</th>
                                                        <th width="15%">Price</th>
                                                        <th width="10%">Total</th>
                                                        <th width="3%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="itemsTableBody">
                                                    <!-- Items will be added here -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                                        <td colspan="2"><strong id="subtotalDisplay">0.00</strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="alert alert-info mt-3" id="emptyState">
                                            <i data-lucide="info" class="icon-sm me-2"></i>
                                            <small>Click "Add Item" to start adding products to this supply order.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- Supply Information -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">
                                            <i data-lucide="info" class="icon-sm me-2"></i>Supply Information
                                        </h5>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Supplier <span class="text-danger">*</span></label>
                                            <select class="form-select" name="supplier_id" required>
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Warehouse <span class="text-danger">*</span></label>
                                            <select class="form-select" name="warehouse_id" required>
                                                <option value="">Select Warehouse</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" name="status" required>
                                                <option value="pending" selected>Pending</option>
                                                <option value="completed">Completed</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                            <small class="text-muted">If completed, stock will be updated automatically</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tax Rate (%)</label>
                                            <input type="number" class="form-control" name="tax_rate" id="taxRate" step="0.01" min="0" max="100" value="0">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="discount_type" id="discountType" required>
                                                <option value="percentage" selected>Percentage (%)</option>
                                                <option value="fixed">Fixed Amount</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Discount Amount</label>
                                            <input type="number" class="form-control" name="discount_amount" id="discountAmount" step="0.01" min="0" value="0">
                                        </div>

                                        <hr>

                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Subtotal:</span>
                                                <strong id="summarySubtotal">0.00</strong>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Tax:</span>
                                                <strong id="summaryTax">0.00</strong>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>Discount:</span>
                                                <strong class="text-success" id="summaryDiscount">0.00</strong>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-0">
                                            <div class="d-flex justify-content-between">
                                                <span class="h5">Total:</span>
                                                <span class="h5 text-primary" id="summaryTotal">0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm">
                                    <i data-lucide="check" class="icon-sm me-1"></i> Create Supply Order
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    
    <script>
        let itemIndex = 0;
        const products = @json($products);

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Add first item row automatically
            addItemRow();
        });

        function addItemRow() {
            const tbody = document.getElementById('itemsTableBody');
            const emptyState = document.getElementById('emptyState');
            
            if (emptyState) {
                emptyState.style.display = 'none';
            }
            
            const row = document.createElement('tr');
            row.id = `item-row-${itemIndex}`;
            row.innerHTML = `
                <td>
                    <select class="form-select form-select-sm" name="items[${itemIndex}][product_id]" onchange="loadVariants(this, ${itemIndex})" required>
                        <option value="">Select Product</option>
                        ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                    </select>
                </td>
                <td>
                    <select class="form-select form-select-sm" name="items[${itemIndex}][variant_id]" id="variant-${itemIndex}" disabled>
                        <option value="">Select Product First</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" name="items[${itemIndex}][qty]" min="1" value="1" onchange="calculateRow(${itemIndex})" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" name="items[${itemIndex}][unit_price]" step="0.01" min="0" onchange="calculateRow(${itemIndex})" required>
                </td>
                <td>
                    <strong id="row-total-${itemIndex}">0.00</strong>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItemRow(${itemIndex})">
                        <i data-lucide="x" class="icon-sm"></i>
                    </button>
                </td>
            `;
            
            tbody.appendChild(row);
            itemIndex++;
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function removeItemRow(index) {
            const row = document.getElementById(`item-row-${index}`);
            if (row) {
                row.remove();
                calculateTotals();
                
                // Show empty state if no rows
                const tbody = document.getElementById('itemsTableBody');
                if (tbody.children.length === 0) {
                    const emptyState = document.getElementById('emptyState');
                    if (emptyState) {
                        emptyState.style.display = 'block';
                    }
                }
            }
        }

        function loadVariants(select, index) {
            const productId = select.value;
            const variantSelect = document.getElementById(`variant-${index}`);
            
            variantSelect.innerHTML = '<option value="">Loading...</option>';
            variantSelect.disabled = true;
            
            if (productId) {
                fetch(`/admin/supplies/variants/${productId}`)
                    .then(response => response.json())
                    .then(variants => {
                        if (variants.length === 0) {
                            variantSelect.innerHTML = '<option value="">No Variant (Simple Product)</option>';
                            variantSelect.disabled = true;
                        } else {
                            variantSelect.innerHTML = '<option value="">Select Variant</option>';
                            variants.forEach(variant => {
                                const option = document.createElement('option');
                                option.value = variant.id;
                                option.textContent = `${variant.sku} - ${variant.attribute_values || 'Default'}`;
                                variantSelect.appendChild(option);
                            });
                            variantSelect.disabled = false;
                        }
                    });
            }
        }

        function calculateRow(index) {
            const row = document.getElementById(`item-row-${index}`);
            if (!row) return;
            
            const qty = parseFloat(row.querySelector(`input[name="items[${index}][qty]"]`).value) || 0;
            const price = parseFloat(row.querySelector(`input[name="items[${index}][unit_price]"]`).value) || 0;
            const total = qty * price;
            
            document.getElementById(`row-total-${index}`).textContent = total.toFixed(2);
            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0;
            const tbody = document.getElementById('itemsTableBody');
            
            Array.from(tbody.children).forEach(row => {
                const totalText = row.querySelector('strong[id^="row-total-"]').textContent;
                subtotal += parseFloat(totalText) || 0;
            });
            
            const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
            const discountType = document.getElementById('discountType').value;
            const discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
            
            const taxAmount = (subtotal * taxRate) / 100;
            let discount = 0;
            
            if (discountType === 'percentage') {
                discount = (subtotal * discountAmount) / 100;
            } else {
                discount = discountAmount;
            }
            
            const total = subtotal + taxAmount - discount;
            
            document.getElementById('subtotalDisplay').textContent = subtotal.toFixed(2);
            document.getElementById('summarySubtotal').textContent = subtotal.toFixed(2);
            document.getElementById('summaryTax').textContent = taxAmount.toFixed(2);
            document.getElementById('summaryDiscount').textContent = discount.toFixed(2);
            document.getElementById('summaryTotal').textContent = total.toFixed(2);
        }

        // Recalculate on tax/discount change
        document.getElementById('taxRate').addEventListener('input', calculateTotals);
        document.getElementById('discountType').addEventListener('change', calculateTotals);
        document.getElementById('discountAmount').addEventListener('input', calculateTotals);
        
        // Form validation
        document.getElementById('supplyForm').addEventListener('submit', function(e) {
            const tbody = document.getElementById('itemsTableBody');
            if (tbody.children.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to the supply order.');
                return false;
            }
        });
    </script>
</body>
</html>
