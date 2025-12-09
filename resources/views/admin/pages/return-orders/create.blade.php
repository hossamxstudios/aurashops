<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Create Return Order</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="py-1 pt-4 row justify-content-center">
                        <div class="text-center col-xxl-9 col-xl-10">
                            <a href="{{ route('admin.return-orders.index') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
                                <i data-lucide="arrow-left" class="fs-sm me-1"></i> Back to Return Orders
                            </a>
                            <h3 class="fw-bold">Create Return Order</h3>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form -->
                    <div class="row justify-content-center">
                        <div class="col-xxl-9 col-xl-10">
                            <form action="{{ route('admin.return-orders.store') }}" method="POST" id="returnOrderForm">
                                @csrf

                                <!-- Client Selection -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Client & Order Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Select Client <span class="text-danger">*</span></label>
                                                <select class="form-select" name="client_id" id="client_id" required>
                                                    <option value="">Choose client...</option>
                                                    @foreach($clients as $client)
                                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                            {{ $client->name }} - {{ $client->email }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Select Order <span class="text-danger">*</span></label>
                                                <select class="form-select" name="order_id" id="order_id" required disabled>
                                                    <option value="">Select client first...</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Return Address <span class="text-danger">*</span></label>
                                                <select class="form-select" name="address_id" id="address_id" required disabled>
                                                    <option value="">Select client first...</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Dropoff Location <span class="text-danger">*</span></label>
                                                <select class="form-select" name="dropoff_location_id" required>
                                                    <option value="">Choose location...</option>
                                                    @foreach($dropoffLocations as $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Return Items -->
                                <div class="mb-3 border-0 shadow-sm card" id="itemsCard" style="display: none;">
                                    <div class="card-body">
                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0 fw-semibold">Return Items</h5>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="showAvailableItems()">
                                                <i data-lucide="plus" class="icon-sm me-1"></i>Add Item
                                            </button>
                                        </div>

                                        <div id="returnItemsList">
                                            <!-- Items will be added here dynamically -->
                                        </div>

                                        <div id="noItemsMessage" class="py-4 text-center text-muted">
                                            <i data-lucide="inbox" class="mb-2 icon-lg" style="opacity: 0.3;"></i>
                                            <p class="mb-0">No items added yet. Click "Add Item" to start.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Additional Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Return Fee ($)</label>
                                                <input type="number" class="form-control" name="return_fee" step="0.01" min="0" value="0" placeholder="0.00">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Shipping Fee ($)</label>
                                                <input type="number" class="form-control" name="shipping_fee" step="0.01" min="0" value="0" placeholder="0.00">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Details</label>
                                                <textarea class="form-control" name="details" rows="3" placeholder="Optional return details"></textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Admin Notes</label>
                                                <textarea class="form-control" name="admin_notes" rows="3" placeholder="Internal notes (not visible to client)"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="mb-3 text-center">
                                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                        <i data-lucide="check" class="icon-sm me-1"></i>Create Return Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    @include('admin.pages.return-orders.itemSelectModal')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let orderItems = [];
        let selectedItems = [];
        let itemCounter = 0;

        // Initialize Select2
        $(document).ready(function() {
            $('#client_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Search for a client...',
                allowClear: true
            });

            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Client changed event (must use jQuery for Select2)
            $('#client_id').on('change', function() {
                const clientId = $(this).val();
                console.log('Client selected:', clientId);

                if (!clientId) {
                    document.getElementById('order_id').disabled = true;
                    document.getElementById('order_id').innerHTML = '<option value="">Select client first...</option>';
                    document.getElementById('address_id').disabled = true;
                    document.getElementById('address_id').innerHTML = '<option value="">Select client first...</option>';
                    document.getElementById('itemsCard').style.display = 'none';
                    return;
                }

                // Load client orders
                fetch(`/admin/return-orders/client/${clientId}/orders`)
                    .then(response => {
                        console.log('Orders response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Orders data:', data);
                        if (data.error) {
                            console.error('Server error:', data.error);
                            alert('Error loading orders: ' + data.error);
                            return;
                        }
                        const orderSelect = document.getElementById('order_id');
                        orderSelect.innerHTML = '<option value="">Choose order...</option>';
                        if (data.orders && data.orders.length > 0) {
                            data.orders.forEach(order => {
                                orderSelect.innerHTML += `<option value="${order.id}">${order.order_number} - ${order.date} (${order.total})</option>`;
                            });
                            orderSelect.disabled = false;
                        } else {
                            orderSelect.innerHTML = '<option value="">No orders found</option>';
                            console.log('No orders found for client');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading orders:', error);
                        alert('Failed to load orders. Check console for details.');
                    });

                // Load client addresses
                fetch(`/admin/return-orders/client/${clientId}/addresses`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Addresses loaded:', data.addresses);
                        const addressSelect = document.getElementById('address_id');
                        addressSelect.innerHTML = '<option value="">Choose address...</option>';
                        data.addresses.forEach(address => {
                            addressSelect.innerHTML += `<option value="${address.id}">${address.label} - ${address.full_address}</option>`;
                        });
                        addressSelect.disabled = false;
                    })
                    .catch(error => console.error('Error loading addresses:', error));
            });

            // Order changed - load items
            $('#order_id').on('change', function() {
                const orderId = $(this).val();
                console.log('Order selected:', orderId);

                if (!orderId) {
                    document.getElementById('itemsCard').style.display = 'none';
                    orderItems = [];
                    return;
                }

                // Load order items
                fetch(`/admin/return-orders/order/${orderId}/items`)
                    .then(response => {
                        console.log('Items response status:', response.status);
                        return response.json();
                    })
                    .then(data => {

                        console.log('Items data:', data);
                        if (data.error) {
                            console.error('Server error:', data.error);
                            alert('Error loading items: ' + data.error);
                            return;
                        }
                        if (data.items && data.items.length > 0) {
                            orderItems = data.items;
                            document.getElementById('itemsCard').style.display = 'block';
                            console.log('Loaded items:', orderItems);
                        } else {
                            console.log('No items found for order');
                            orderItems = [];
                            alert('This order has no items to return.');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading items:', error);
                        alert('Failed to load order items. Check console for details.');
                    });
            });
        });

        // Show available items modal
        function showAvailableItems() {
            if (orderItems.length === 0) {
                alert('Please select an order first');
                return;
            }

            const tbody = document.getElementById('availableItemsBody');
            tbody.innerHTML = '';

            orderItems.forEach(item => {
                const isAdded = selectedItems.some(si => si.order_item_id === item.id);
                if (!isAdded) {
                    const unitPrice = parseFloat(item.unit_price) || 0;
                    const total = parseFloat(item.total) || 0;
                    const productName = (item.product_name || '').replace(/'/g, "\\'");
                    const row = `
                        <tr>
                            <td>
                                <strong>${item.product_name}</strong>
                                ${item.variant_name ? `<br><small class="text-muted">${item.variant_name}</small>` : ''}
                            </td>
                            <td>${item.qty}</td>
                            <td>$${unitPrice.toFixed(2)}</td>
                            <td>$${total.toFixed(2)}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="selectItemForReturn(${item.id}, '${productName}', ${unitPrice}, ${item.qty})">
                                    Select
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                }
            });

            new bootstrap.Modal(document.getElementById('itemSelectModal')).show();
        }

        // Select item for return
        function selectItemForReturn(itemId, productName, unitPrice, maxQty) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('itemSelectModal'));
            modal.hide();

            // Show item form
            addReturnItemForm(itemId, productName, unitPrice, maxQty);
        }

        // Add return item form
        function addReturnItemForm(orderItemId, productName, unitPrice, maxQty) {
            itemCounter++;
            const itemHtml = `
                <div class="p-3 mb-3 rounded border return-item" id="item_${itemCounter}">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">${productName}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(${itemCounter})">
                            <i data-lucide="x" class="icon-sm"></i>
                        </button>
                    </div>
                    <input type="hidden" name="items[${itemCounter}][order_item_id]" value="${orderItemId}">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="items[${itemCounter}][qty]" min="1" max="${maxQty}" value="1" required>
                            <small class="text-muted">Max: ${maxQty}</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reason <span class="text-danger">*</span></label>
                            <select class="form-select" name="items[${itemCounter}][reason_id]" required>
                                <option value="">Choose reason...</option>
                                @foreach($reasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Details</label>
                            <input type="text" class="form-control" name="items[${itemCounter}][details]" placeholder="Optional details">
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('returnItemsList').insertAdjacentHTML('beforeend', itemHtml);
            document.getElementById('noItemsMessage').style.display = 'none';
            document.getElementById('submitBtn').disabled = false;

            selectedItems.push({ order_item_id: orderItemId, counter: itemCounter });

            // Reinitialize icons
            lucide.createIcons();
        }

        // Remove item
        function removeItem(counter) {
            document.getElementById(`item_${counter}`).remove();
            selectedItems = selectedItems.filter(item => item.counter !== counter);

            if (selectedItems.length === 0) {
                document.getElementById('noItemsMessage').style.display = 'block';
                document.getElementById('submitBtn').disabled = true;
            }
        }
    </script>
</body>
</html>
