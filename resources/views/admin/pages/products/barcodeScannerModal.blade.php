<!-- Barcode Scanner Modal -->
<div class="modal fade" id="barcodeScannerModal" tabindex="-1" aria-labelledby="barcodeScannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title" id="barcodeScannerModalLabel">
                    <i class="ti ti-qrcode me-2"></i>
                    Scan Barcode
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product Info -->
                <div class="alert alert-info mb-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-package me-2" style="font-size: 1.5rem;"></i>
                        <div>
                            <small class="text-muted d-block">Product:</small>
                            <strong id="scanProductName"></strong>
                        </div>
                    </div>
                </div>

                <!-- Barcode Input -->
                <div class="mb-3">
                    <label for="barcodeInput" class="form-label fw-semibold">
                        <i class="ti ti-scan me-1"></i>
                        Barcode
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light">
                            <i class="ti ti-barcode"></i>
                        </span>
                        <input 
                            type="text" 
                            class="form-control form-control-lg" 
                            id="barcodeInput" 
                            placeholder="Scan or enter barcode..."
                            autocomplete="off"
                        >
                    </div>
                    <small class="form-text text-muted">
                        <i class="ti ti-info-circle me-1"></i>
                        Use a barcode scanner or manually enter the barcode number
                    </small>
                </div>

                <!-- Error Message -->
                <div id="barcodeError" class="alert alert-danger d-none" role="alert">
                    <i class="ti ti-alert-circle me-1"></i>
                    <span></span>
                </div>

                <!-- Scanner Icon Animation -->
                <div class="text-center py-4">
                    <div class="scanner-animation">
                        <i class="ti ti-qrcode text-warning" style="font-size: 5rem; opacity: 0.3;"></i>
                        <div class="scanner-line"></div>
                    </div>
                    <p class="text-muted mt-3">
                        Ready to scan barcode
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-warning" id="saveBarcodeBtn" onclick="saveBarcode()">
                    <i class="ti ti-check me-1"></i>
                    Save Barcode
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .scanner-animation {
        position: relative;
        display: inline-block;
    }

    .scanner-line {
        position: absolute;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #ffc107, transparent);
        top: 0;
        left: 0;
        animation: scan 2s ease-in-out infinite;
        box-shadow: 0 0 10px #ffc107;
    }

    @keyframes scan {
        0%, 100% {
            top: 0;
            opacity: 0;
        }
        50% {
            top: 100%;
            opacity: 1;
        }
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .rotate {
        animation: rotate 1s linear infinite;
    }

    #barcodeInput:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }
</style>
