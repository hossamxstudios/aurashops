<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger-subtle">
                <h5 class="modal-title text-danger" id="deleteModalLabel">
                    <i class="ti ti-alert-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 text-center">
                    <div class="mx-auto mb-3 avatar-xl">
                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                            <i class="ti ti-trash fs-1"></i>
                        </div>
                    </div>
                    <h4 class="mb-2">Are you sure?</h4>
                    <p class="mb-0 text-muted">Do you really want to delete <strong id="deleteProductName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteProduct(productId, productName) {
        document.getElementById('deleteProductName').textContent = productName;
        document.getElementById('deleteProductForm').action = `/admin/products/${productId}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
