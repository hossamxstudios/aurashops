<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>POS - Point of Sale</title>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%);
            --success-gradient: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            --danger-gradient: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --card-shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        body { overflow: hidden; font-family: 'Inter', -apple-system, system-ui, sans-serif; }

        /* Modern Container */
        .pos-container {
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fb 100%);
        }

        /* Elevated Header */
        .pos-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 10px 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(10px);
        }

        /* Products Section */
        .pos-products {
            height: calc(100vh - 200px);
            overflow-y: auto;
            padding: 8px;
        }
        .pos-products::-webkit-scrollbar { width: 8px; }
        .pos-products::-webkit-scrollbar-track { background: transparent; }
        .pos-products::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }

        /* Cart Section */
        .pos-cart {
            height: 100vh;
            background: #fff;
            border-left: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.03);
        }

        /* Product Cards - Minimal & Clean */
        .product-card {
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            box-shadow: var(--card-shadow);
            position: relative;
        }
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .product-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: var(--card-shadow-hover);
            /* border-color: #4a4a4a; */
        }
        .product-card:active { transform: translateY(-2px) scale(0.98); }

        /* Image Container for 1:1 ratio */
        .product-card .card-img-top {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        /* Fallback for browsers that don't support aspect-ratio */
        @supports not (aspect-ratio: 1 / 1) {
            .product-card .card-img-top {
                height: 0;
                padding-bottom: 100%;
                position: relative;
            }
            .product-card .card-img-top img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        /* Cart Items - Minimal Enhanced */
        .cart-item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            transition: all 0.2s ease;
            background: #fff;
        }
        .cart-item:hover {
            border-color: #dee2e6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }
        .cart-item:last-child {
            margin-bottom: 0;
        }

        /* Cart Item Content Alignment */
        .cart-item .flex-grow-1 {
            min-width: 0;
            padding-right: 8px;
            flex: 1 1 auto;
        }

        /* Cart Item Controls Wrapper */
        .cart-item .d-flex.align-items-center.gap-2:last-child {
            flex-shrink: 0;
        }

        /* Cart Item Image */
        .cart-item img {
            border: 1px solid #e9ecef;
            transition: all 0.2s;
        }
        .cart-item:hover img {
            border-color: #1a1a1a;
        }

        /* Cart Item Title */
        .cart-item-title {
            font-weight: 600;
            color: #1a1a1a;
            line-height: 1.3;
        }

        /* Cart Item Price */
        .cart-item-price {
            color: #6c757d;
            font-size: 0.8rem;
        }

        /* Quantity Controls */
        .qty-controls {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 2px;
            border: 1px solid #e9ecef;
            white-space: nowrap;
        }
        .qty-controls .btn {
            color: #495057;
            transition: all 0.15s;
            min-width: 28px;
        }
        .qty-controls .btn:hover {
            background: #e9ecef;
            color: #1a1a1a;
        }
        .qty-controls input {
            font-size: 0.85rem !important;
            padding: 4px !important;
        }
        .qty-controls input:focus {
            outline: none;
            box-shadow: none;
        }

        /* Delete Button */
        .cart-item .btn-delete {
            opacity: 0.7;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .cart-item:hover .btn-delete {
            opacity: 1;
        }
        .cart-item .btn-delete:hover {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            border-color: #dc3545 !important;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        .cart-item .btn-delete:hover i {
            color: white !important;
        }
        .cart-item .btn-delete:active {
            transform: scale(0.95);
        }

        /* Cart Totals */
        .cart-total {
            background: linear-gradient(180deg, #f8f9fb 0%, #fff 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            padding: 16px;
        }

        /* Payment Section */
        .payment-section {
            background: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            padding: 16px;
        }

        /* Barcode Input - Modern */
        .barcode-input {
            font-family: 'SF Mono', 'Courier New', monospace;
            font-size: 0.95rem;
            border: 2px solid #e1e8ed;
            transition: all 0.2s;
        }
        .barcode-input:focus {
            border-color: #4a4a4a;
            box-shadow: 0 0 0 4px rgba(74, 74, 74, 0.1);
        }

        /* Buttons */
        .qty-btn {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 6px;
            transition: all 0.2s;
            font-size: 0.85rem;
        }
        .qty-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Session Info Badge */
        .session-info {
            background: var(--primary-gradient);
            color: white;
            border-radius: 8px;
            padding: 8px 16px;
            box-shadow: 0 4px 12px rgba(26, 26, 26, 0.3);
            font-size: 0.9rem;
        }

        /* Badges */
        .bg-purple { background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%) !important; }

        /* Custom Scrollbar */
        .pos-cart::-webkit-scrollbar { width: 6px; }
        .pos-cart::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        /* Smooth Animations */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in { animation: slideInUp 0.3s ease-out; }

        /* Glass Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Enhanced Button Styles */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            box-shadow: 0 4px 12px rgba(26, 26, 26, 0.3);
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 26, 26, 0.4);
        }

        .btn-success {
            background: var(--success-gradient);
            border: none;
            box-shadow: 0 4px 12px rgba(45, 55, 72, 0.3);
        }

        .btn-danger {
            background: var(--danger-gradient);
            border: none;
            box-shadow: 0 4px 12px rgba(45, 55, 72, 0.3);
        }

        /* Payment Method Buttons */
        .payment-method-btn {
            transition: all 0.2s;
        }
        .payment-method-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="overflow-scroll pos-container">
        <!-- POS Header -->
        <div class="pos-header d-flex justify-content-between align-items-center">
            <div class="gap-3 d-flex align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary"> <i data-lucide="arrow-left" class="icon-sm"></i> Exit POS </a>
                <div class="px-3 py-2 rounded session-info">
                    <small class="opacity-75 d-block">Session #{{ $activeSession->id }} - {{ Auth::user()->name }}</small>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center">
                <div class="text-end me-3">
                    <small class="text-muted d-block">Session Started</small>
                    <strong>{{ $activeSession->opened_at->format('h:i A') }}</strong>
                </div>
                <button class="btn btn-danger" onclick="closeSession()"> <i data-lucide="lock" class="icon-sm me-1"></i> Close Session </button>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-lg-8">
                <div class="p-3">
                    <div class="mb-3 animate-in">
                        <div class="shadow-sm input-group" style="border-radius: 10px; overflow: hidden;">
                            <span class="border-0 input-group-text" style="background: var(--primary-gradient); padding: 8px 12px;">
                                <i data-lucide="scan-barcode" class="text-white icon-sm" style="width: 18px; height: 18px;"></i>
                            </span>
                            <input type="text" class="border-0 form-control barcode-input ps-2" id="barcodeInput" placeholder="Scan barcode or search product..." style="font-size: 0.95rem; padding: 8px;" autofocus>
                            <button class="border-0 btn btn-light" type="button" onclick="searchProducts()" style="background: #f8f9fb; padding: 8px 12px;">
                                <i data-lucide="search" class="text-primary" style="width: 18px; height: 18px;"></i>
                            </button>
                        </div>
                        <div class="gap-1 mt-2 d-flex align-items-center ms-1">
                            <i data-lucide="zap" class="icon-xs text-warning" style="width: 14px; height: 14px;"></i>
                            <small class="text-muted" style="font-size: 0.8rem;">Scan barcode or search product</small>
                        </div>
                    </div>
                    <div class="p-2 pos-products">
                        <div class="row g-2" id="productsGrid">
                            <div class="py-5 text-center col-12">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Loading products...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="pos-cart d-flex flex-column">
                    <div class="gap-3 p-3 border-bottom d-flex align-items-center" style="background: linear-gradient(180deg, #fff 0%, #f8f9fb 100%);">
                        <label class="gap-2 mb-0 form-label fw-semibold d-flex align-items-center" style="font-size: 0.9rem; white-space: nowrap;">
                            <div class="d-flex align-items-center justify-content-center"
                                 style="width: 28px; height: 28px; background: var(--primary-gradient); border-radius: 6px;">
                                <i data-lucide="user" class="text-white icon-sm" style="width: 16px; height: 16px;"></i>
                            </div>
                            <span>Customer</span>
                        </label>
                        <select class="shadow-sm form-select flex-grow-1" id="customerSelect"
                                style="border: 2px solid #e1e8ed; border-radius: 8px; padding: 8px; font-size: 0.9rem;">
                            <option value="">👤 Walk-in Customer</option>
                            @foreach(\App\Models\Client::orderBy('email')->limit(100)->get() as $client)
                                <option value="{{ $client->id }}">{{ $client->full_name }} • {{ $client->email }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="overflow-auto flex-grow-1" id="cartItems">
                        <div class="py-5 text-center text-muted">
                            <i data-lucide="shopping-cart" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                            <p class="mt-2">Cart is empty</p>
                            <small>Scan or select products to add</small>
                        </div>
                    </div>

                    <!-- Cart Totals - Enhanced -->
                    <div class="cart-total" style="padding: 16px;">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.85rem;">Subtotal</span>
                            <strong id="subtotalAmount" style="font-size: 0.95rem;">0.00 EGP</strong>
                        </div>
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.85rem;">Discount</span>
                            <div class="shadow-sm input-group" style="width: 110px; border-radius: 6px; overflow: hidden;">
                                <input type="number" class="border-0 form-control text-end" id="discountInput" value="0" min="0" step="0.01" oninput="calculateTotals()" style="padding: 6px; font-size: 0.85rem;">
                                <span class="border-0 input-group-text bg-light" style="font-size: 0.85rem; padding: 6px 8px;">EGP</span>
                            </div>
                        </div>
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size: 0.85rem;">Tax</span>
                            <div class="gap-2 d-flex align-items-center">
                                <div class="shadow-sm input-group" style="width: 80px; border-radius: 6px; overflow: hidden;">
                                    <input type="number" class="border-0 form-control text-end" id="taxInput" value="0" min="0" max="100" step="0.01" oninput="calculateTotals()" style="padding: 6px; font-size: 0.85rem;">
                                    <span class="border-0 input-group-text bg-light" style="font-size: 0.85rem; padding: 6px 8px;">%</span>
                                </div>
                                <strong id="taxAmount" style="font-size: 0.9rem; min-width: 70px; text-align: right;">0.00 EGP</strong>
                            </div>
                        </div>
                        <div class="pt-2 mt-2 border-top"></div>
                        <div class="d-flex justify-content-between align-items-center"
                             style="background: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%); padding: 12px; border-radius: 10px; margin-top: 8px;">
                            <h6 class="mb-0 text-white fw-bold">TOTAL</h6>
                            <h5 class="mb-0 text-white fw-bold" id="totalAmount">0.00 EGP</h5>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="payment-section" style="padding: 16px;">
                        <div class="gap-2 d-grid">
                            <button class="shadow btn btn-success"
                                    onclick="showPaymentModal()"
                                    id="completeBtn"
                                    disabled
                                    style="border-radius: 8px; padding: 10px; font-weight: 600; font-size: 0.95rem;">
                                <i data-lucide="check-circle" class="icon-sm me-1" style="width: 18px; height: 18px;"></i>
                                Complete Order
                            </button>
                            <button class="btn btn-outline-danger"
                                    onclick="clearCart()"
                                    style="border-radius: 8px; padding: 8px; font-weight: 500; font-size: 0.9rem;">
                                <i data-lucide="x" class="icon-sm me-1" style="width: 16px; height: 16px;"></i>
                                Clear Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i data-lucide="credit-card" class="icon-sm me-2"></i>
                        Complete Payment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="mb-3 form-label fw-semibold">
                            <i data-lucide="wallet" class="icon-sm me-1"></i>
                            Select Payment Method
                        </label>
                        <div class="gap-2 d-grid" id="paymentMethodsList">
                            @foreach($paymentMethods as $method)
                                <button type="button"
                                        class="btn btn-outline-dark text-start payment-method-btn"
                                        data-method-id="{{ $method->id }}"
                                        onclick="selectPaymentMethod({{ $method->id }})"
                                        style="border-radius: 8px; padding: 12px; border: 2px solid #e1e8ed;">
                                    <i data-lucide="check-circle" class="icon-sm me-2" style="width: 18px; height: 18px;"></i>
                                    <strong>{{ $method->name }}</strong>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cash Payment Section -->
                    <div id="cashPaymentSection" style="display: none;">
                        <div class="p-3 mb-3 rounded bg-light">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label small fw-semibold">Total Amount</label>
                                    <input type="text" class="bg-white form-control" id="modalTotalAmount" readonly style="font-weight: 600; font-size: 1.1rem;">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-semibold">Cash Received <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control"
                                           id="modalCashReceived"
                                           step="0.01"
                                           placeholder="0.00"
                                           oninput="calculateModalChange()"
                                           style="border: 2px solid #e1e8ed; font-weight: 600;">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="form-label small fw-semibold">Change</label>
                                <input type="text"
                                       class="shadow-sm form-control"
                                       id="modalChangeAmount"
                                       readonly
                                       value="0.00 EGP"
                                       style="background: linear-gradient(135deg, #f8f9fb 0%, #e1e8ed 100%); border: none; border-radius: 8px; padding: 8px; font-weight: 600; font-size: 0.9rem;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmPaymentBtn" onclick="confirmPayment()" disabled>
                        <i data-lucide="check" class="icon-sm me-1"></i>
                        Confirm Payment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Variant Selection Modal -->
    <div class="modal fade" id="variantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="variantModalBody">
                    <!-- Variants will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bundle Configuration Modal -->
    <div class="modal fade" id="bundleModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i data-lucide="package" class="icon-sm me-2"></i>
                        Configure Bundle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="bundleModalBody">
                    <!-- Bundle configuration will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="addBundleBtn" onclick="addBundleToCart()" disabled>
                        <i data-lucide="plus-circle" class="icon-sm me-1"></i>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Close Session Modal -->
    <div class="modal fade" id="closeSessionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Close POS Session</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i data-lucide="alert-triangle" class="icon-sm me-2"></i>
                        Make sure you have counted all cash before closing.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expected Cash</label>
                        <input type="text" class="form-control bg-light" id="expectedCash" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Actual Cash <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="actualCash" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Difference</label>
                        <input type="text" class="form-control" id="cashDifference" readonly>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="sessionNotes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmCloseSession()">Close Session</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.main.scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/pos.js') }}"></script>
</body>
</html>
