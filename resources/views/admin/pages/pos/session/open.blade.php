<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Open POS Session - Admin</title>
    <style>
        body { 
            background: #f8f9fa;
            min-height: 100vh;
        }
        .session-card {
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            background: #fff;
            border: 1px solid #e9ecef;
        }
        .icon-wrapper {
            width: 60px;
            height: 60px;
            background: #1a1a1a;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        .quick-amount {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            transition: all 0.15s;
            background: #fff;
        }
        .quick-amount:hover {
            border-color: #1a1a1a;
            background: #f8f9fa;
        }
        .quick-amount.active {
            border-color: #1a1a1a;
            background: #1a1a1a;
            color: white;
        }
        .amount-input {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 14px;
        }
        .amount-input:focus {
            border-color: #1a1a1a;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.08);
        }
        .btn-start {
            background: #1a1a1a;
            border: none;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.2s;
        }
        .btn-start:hover {
            background: #000;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="py-5 row justify-content-center">
                        <div class="col-md-7 col-lg-5">
                            <div class="text-center mb-4">
                                <div class="icon-wrapper">
                                    <i data-lucide="wallet" class="text-white" style="width: 28px; height: 28px;"></i>
                                </div>
                                <h2 class="mt-3 fw-bold" style="font-size: 1.5rem; color: #1a1a1a;">Open POS Session</h2>
                                <p class="text-muted mt-1 mb-0" style="font-size: 0.95rem;">Enter opening cash to start</p>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card session-card">
                                <div class="card-body p-4">
                                    <form action="{{ route('admin.pos.session.open') }}" method="POST" id="sessionForm">
                                        @csrf
                                        
                                        <!-- Quick Amount Buttons -->
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-2" style="font-weight: 500;">Quick Amount</label>
                                            <div class="row g-2">
                                                <div class="col-3">
                                                    <div class="quick-amount text-center" onclick="setAmount(0)">
                                                        <div class="fw-semibold" style="font-size: 0.95rem;">0</div>
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">EGP</small>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="quick-amount text-center" onclick="setAmount(500)">
                                                        <div class="fw-semibold" style="font-size: 0.95rem;">500</div>
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">EGP</small>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="quick-amount text-center" onclick="setAmount(1000)">
                                                        <div class="fw-semibold" style="font-size: 0.95rem;">1000</div>
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">EGP</small>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="quick-amount text-center" onclick="setAmount(2000)">
                                                        <div class="fw-semibold" style="font-size: 0.95rem;">2000</div>
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">EGP</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Custom Amount Input -->
                                        <div class="mb-3">
                                            <label class="form-label small text-muted mb-2" style="font-weight: 500;">Or Enter Custom Amount</label>
                                            <input type="number" 
                                                   class="form-control amount-input @error('opening_cash') is-invalid @enderror" 
                                                   name="opening_cash" 
                                                   id="openingCash"
                                                   step="0.01" 
                                                   min="0" 
                                                   placeholder="0"
                                                   value="{{ old('opening_cash', '0') }}"
                                                   autofocus
                                                   required>
                                            <small class="text-muted d-block text-center mt-1" style="font-size: 0.85rem;">Egyptian Pound</small>
                                            @error('opening_cash')
                                                <div class="invalid-feedback d-block text-center">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-lg w-100 text-white btn-start">
                                            <i data-lucide="arrow-right" style="width: 18px; height: 18px;" class="me-2"></i>
                                            <span class="fw-semibold">Start Session</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="text-center mt-3">
                                <small class="text-muted" style="font-size: 0.85rem;">
                                    <i data-lucide="user" style="width: 14px; height: 14px;"></i>
                                    {{ Auth::user()->name }} • 
                                    {{ now()->format('d/m/Y h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    <script>
        function setAmount(amount) {
            // Set the input value
            document.getElementById('openingCash').value = amount;
            
            // Remove active class from all quick amounts
            document.querySelectorAll('.quick-amount').forEach(el => {
                el.classList.remove('active');
            });
            
            // Add active class to clicked button
            event.currentTarget.classList.add('active');
            
            // Focus on input
            document.getElementById('openingCash').focus();
        }
        
        // Clear active state when user manually types
        document.getElementById('openingCash').addEventListener('input', function() {
            document.querySelectorAll('.quick-amount').forEach(el => {
                el.classList.remove('active');
            });
        });
        
        // Initialize lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
</body>
</html>
