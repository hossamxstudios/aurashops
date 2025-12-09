<!-- Product Selector Modal -->
<div class="modal fade" id="productSelectorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="border-0 modal-header bg-light">
                <div class="w-100">
                    <h5 class="mb-3 modal-title fw-semibold">
                        <i class="ti ti-package me-2 text-primary"></i>Select Product for Bundle
                    </h5>
                    <!-- Search Bar -->
                    <div class="input-group">
                        <span class="bg-white input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="productSearchInput" placeholder="Search products by name or SKU..." onkeyup="searchProducts()">
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="p-4 modal-body" style="min-height: 400px;">
                <!-- Loading Spinner -->
                <div id="productLoadingSpinner" class="py-5 text-center d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading products...</p>
                </div>

                <!-- Products Grid -->
                <div id="productsGrid" class="row g-3">
                    <!-- Products will be loaded here via AJAX -->
                </div>

                <!-- No Results Message -->
                <div id="noProductsMessage" class="py-5 text-center d-none">
                    <i class="ti ti-package-off text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="mt-3 text-muted">No products found</p>
                </div>

                <!-- Pagination -->
                <div id="productPagination" class="mt-4">
                    <!-- Pagination will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
let searchQuery = '';
let currentBundleItemIndex = null;

function openProductSelector(bundleItemIndex) {
    currentBundleItemIndex = bundleItemIndex;
    currentPage = 1;
    searchQuery = '';
    document.getElementById('productSearchInput').value = '';

    const modal = new bootstrap.Modal(document.getElementById('productSelectorModal'));
    modal.show();

    loadProducts();
}

function searchProducts() {
    searchQuery = document.getElementById('productSearchInput').value;
    currentPage = 1;
    loadProducts();
}

function loadProducts(page = 1) {
    currentPage = page;

    const spinner = document.getElementById('productLoadingSpinner');
    const grid = document.getElementById('productsGrid');
    const noResults = document.getElementById('noProductsMessage');
    const pagination = document.getElementById('productPagination');

    // Show spinner
    spinner.classList.remove('d-none');
    grid.innerHTML = '';
    noResults.classList.add('d-none');
    pagination.innerHTML = '';

    // AJAX request
    fetch(`/admin/products/search?page=${page}&search=${encodeURIComponent(searchQuery)}&exclude_bundle=1`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        spinner.classList.add('d-none');

        if (data.products && data.products.length > 0) {
            renderProducts(data.products);
            renderPagination(data.pagination);
        } else {
            noResults.classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Error loading products:', error);
        spinner.classList.add('d-none');
        noResults.classList.remove('d-none');
    });
}

function renderProducts(products) {
    const grid = document.getElementById('productsGrid');
    grid.innerHTML = '';

    products.forEach(product => {
        const thumbnail = product.thumbnail || '/images/placeholder.png';
        const price = parseFloat(product.price || 0).toFixed(2);
        const salePrice = product.sale_price > 0 ? parseFloat(product.sale_price).toFixed(2) : null;
        const typeColor = product.type === 'simple' ? 'info' : 'warning';

        const card = `
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="border card h-100 product-select-card" onclick="selectProduct(${product.id}, '${escapeHtml(product.name)}', '${product.type}', '${thumbnail}', ${price}, ${salePrice})" style="cursor: pointer; transition: all 0.3s;">
                    <div class="position-relative">
                        <img src="${thumbnail}" class="card-img-top" alt="${escapeHtml(product.name)}" style="height: 180px; object-fit: cover;">
                        <span class="position-absolute top-0 end-0 m-2 badge bg-${typeColor}">
                            ${product.type.charAt(0).toUpperCase() + product.type.slice(1)}
                        </span>
                        ${product.variant_count > 0 ? `
                            <span class="bottom-0 m-2 position-absolute start-0 badge bg-dark">
                                ${product.variant_count} Variants
                            </span>
                        ` : ''}
                    </div>
                    <div class="card-body">
                        <h6 class="mb-2 card-title fw-semibold text-truncate" title="${escapeHtml(product.name)}">
                            ${escapeHtml(product.name)}
                        </h6>
                        <p class="mb-2 card-text text-muted small">
                            <i class="ti ti-barcode me-1"></i>${product.sku || 'No SKU'}
                        </p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                ${salePrice ? `
                                    <span class="text-decoration-line-through text-muted me-2">$${price}</span>
                                    <span class="fw-bold text-danger">$${salePrice}</span>
                                ` : `
                                    <span class="fw-bold text-primary">$${price}</span>
                                `}
                            </div>
                            <button class="btn btn-sm btn-primary">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        grid.insertAdjacentHTML('beforeend', card);
    });

    // Add hover effect
    document.querySelectorAll('.product-select-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
}

function renderPagination(pagination) {
    if (!pagination || pagination.total_pages <= 1) return;

    const paginationDiv = document.getElementById('productPagination');
    let html = '<nav><ul class="mb-0 pagination justify-content-center">';

    // Previous button
    html += `
        <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); loadProducts(${pagination.current_page - 1})">
                <i class="ti ti-chevron-left"></i>
            </a>
        </li>
    `;

    // Page numbers
    const startPage = Math.max(1, pagination.current_page - 2);
    const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);

    if (startPage > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); loadProducts(1)">1</a></li>`;
        if (startPage > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }

    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadProducts(${i})">${i}</a>
            </li>
        `;
    }

    if (endPage < pagination.total_pages) {
        if (endPage < pagination.total_pages - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        html += `<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); loadProducts(${pagination.total_pages})">${pagination.total_pages}</a></li>`;
    }

    // Next button
    html += `
        <li class="page-item ${pagination.current_page === pagination.total_pages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="event.preventDefault(); loadProducts(${pagination.current_page + 1})">
                <i class="ti ti-chevron-right"></i>
            </a>
        </li>
    `;

    html += '</ul></nav>';
    paginationDiv.innerHTML = html;
}

function selectProduct(id, name, type, thumbnail, price, salePrice) {
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('productSelectorModal'));
    modal.hide();

    // Add selected product to bundle items
    addSelectedProductToBundleItem(currentBundleItemIndex, {
        id: id,
        name: name,
        type: type,
        thumbnail: thumbnail,
        price: price,
        sale_price: salePrice
    });
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
</script>

<style>
.product-select-card {
    transition: all 0.3s ease;
}

.product-select-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
