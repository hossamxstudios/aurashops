<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Products</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.products.parts.header')
                    @include('admin.main.messages')
                    @include('admin.pages.products.parts.filters')
                    @include('admin.pages.products.table')
                    @include('admin.pages.products.deleteModal')
                    @include('admin.pages.products.barcodeScannerModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')

    <script>
        let currentProductId = null;
        let currentProductName = '';

        function openBarcodeScanner(productId, productName) {
            currentProductId = productId;
            currentProductName = productName;
            document.getElementById('scanProductName').textContent = productName;
            document.getElementById('barcodeInput').value = '';
            document.getElementById('barcodeError').classList.add('d-none');
            const modal = new bootstrap.Modal(document.getElementById('barcodeScannerModal'));
            modal.show();
            // Focus on input for scanner
            setTimeout(() => {
                document.getElementById('barcodeInput').focus();
            }, 500);
        }

        function saveBarcode() {
            const barcode = document.getElementById('barcodeInput').value.trim();
            const errorDiv = document.getElementById('barcodeError');
            const saveBtn = document.getElementById('saveBarcodeBtn');

            if (!barcode) {
                errorDiv.textContent = 'Please enter or scan a barcode';
                errorDiv.classList.remove('d-none');
                return;
            }

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="ti ti-loader rotate me-1"></i>Saving...';

            fetch(`/admin/products/${currentProductId}/save-barcode`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ barcode: barcode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('barcodeScannerModal'));
                    modal.hide();
                    // Reload page to show updated barcode
                    window.location.reload();
                } else {
                    errorDiv.textContent = data.message || 'Failed to save barcode';
                    errorDiv.classList.remove('d-none');
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.classList.remove('d-none');
            })
            .finally(() => {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="ti ti-check me-1"></i>Save Barcode';
            });
        }

        // Handle Enter key in barcode input
        document.addEventListener('DOMContentLoaded', function() {
            const barcodeInput = document.getElementById('barcodeInput');
            if (barcodeInput) {
                barcodeInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        saveBarcode();
                    }
                });
            }
        });
    </script>
</body>
</html>
