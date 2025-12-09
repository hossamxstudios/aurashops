<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - {{ $product->name }}</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Header -->
                    <div class="py-1 pt-4 row">
                        <div class="col-12">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('admin.products.index') }}" class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm">
                                        <i data-lucide="arrow-left" class="fs-sm me-1"></i> Back to Products
                                    </a>
                                    <h3 class="mb-1 fw-bold">{{ $product->name }}</h3>
                                    <div class="gap-2 d-flex align-items-center">
                                        <span class="badge {{ $product->type === 'simple' ? 'bg-info' : 'bg-warning' }}">
                                            {{ ucfirst($product->type) }} Product
                                        </span>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="badge bg-primary">Featured</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="gap-2 d-flex">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                                        <i class="ti ti-edit me-1"></i>Edit Product
                                    </a>
                                    <button class="btn btn-danger-subtle text-danger" onclick="deleteProduct({{ $product->id }}, '{{ $product->name }}')">
                                        <i class="ti ti-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.main.messages')
                    <div class="row">
                        <!-- Left Column - Images & Gallery -->
                        <div class="col-lg-4">
                            <!-- Main Image -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Product Image</h5>
                                    @if($product->getMedia('product_thumbnail')->first())
                                        <div class="text-center">
                                            <img src="{{ $product->getMedia('product_thumbnail')->first()->getUrl() }}"
                                                 alt="{{ $product->name }}"
                                                 class="rounded img-fluid"
                                                 style="max-height: 400px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="py-5 text-center rounded bg-light">
                                            <i class="ti ti-photo text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                                            <p class="mt-3 text-muted">No product image</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Gallery -->
                            @if($product->getMedia('product_images')->count() > 0)
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Image Gallery</h5>
                                    <div class="row g-2">
                                        @foreach($product->getMedia('product_images') as $image)
                                            <div class="col-6">
                                                <img src="{{ $image->getUrl() }}"
                                                     alt="Gallery Image"
                                                     class="rounded img-fluid w-100"
                                                     style="height: 120px; object-fit: cover; cursor: pointer;"
                                                     onclick="viewImage('{{ $image->getUrl() }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Quick Stats -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Statistics</h5>
                                    <div class="mb-3">
                                        <div class="mb-1 d-flex justify-content-between align-items-center">
                                            <span class="text-muted fs-sm">Views</span>
                                            <span class="fw-semibold">{{ number_format($product->views_count) }}</span>
                                        </div>
                                        <div class="mb-1 d-flex justify-content-between align-items-center">
                                            <span class="text-muted fs-sm">Orders</span>
                                            <span class="fw-semibold">{{ number_format($product->orders_count) }}</span>
                                        </div>
                                        @if($product->rating)
                                        <div class="mb-1 d-flex justify-content-between align-items-center">
                                            <span class="text-muted fs-sm">Rating</span>
                                            <span class="fw-semibold">
                                                <i class="ti ti-star-filled text-warning"></i>
                                                {{ number_format($product->rating, 1) }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                    <hr class="my-3">
                                    <div>
                                        <div class="mb-1 d-flex justify-content-between align-items-center">
                                            <span class="text-muted fs-sm">Created</span>
                                            <span class="fs-xs">{{ $product->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted fs-sm">Last Updated</span>
                                            <span class="fs-xs">{{ $product->updated_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column - Product Details -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">Basic Information</h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="mb-1 text-muted fs-sm">Product Name</label>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                        </div>
                                        @if($product->sku)
                                        <div class="col-md-6">
                                            <label class="mb-1 text-muted fs-sm">SKU</label>
                                            <div class="fw-semibold">{{ $product->sku }}</div>
                                        </div>
                                        @endif
                                        @if($product->brand)
                                        <div class="col-md-6">
                                            <label class="mb-1 text-muted fs-sm">Brand</label>
                                            <div class="fw-semibold">{{ $product->brand->name }}</div>
                                        </div>
                                        @endif
                                        @if($product->gender)
                                        <div class="col-md-6">
                                            <label class="mb-1 text-muted fs-sm">Gender</label>
                                            <div class="fw-semibold">{{ $product->gender->name }}</div>
                                        </div>
                                        @endif
                                        <div class="col-12">
                                            <label class="mb-1 text-muted fs-sm">Description</label>
                                            <div class="text-dark">{{ $product->details }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">
                                        <i class="ti ti-currency-dollar me-2 text-muted"></i>Pricing Information
                                    </h5>
                                    <div class="row g-2">
                                        @if($product->base_price > 0)
                                        <div class="col-md-4">
                                            <div class="p-3 rounded border bg-light h-100">
                                                <div class="gap-2 mb-2 d-flex align-items-center">
                                                    <div class="bg-white rounded border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                        <i class="ti ti-shopping-cart text-muted"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Base Price</small>
                                                        <small class="text-muted" style="font-size: 0.7rem;">Wholesale</small>
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-dark" style="font-size: 1.5rem;">{{ number_format($product->base_price, 2) }} EGP</div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-{{ $product->base_price > 0 ? '4' : '6' }}">
                                            <div class="p-3 rounded border bg-light h-100">
                                                <div class="gap-2 mb-2 d-flex align-items-center">
                                                    <div class="rounded border bg-primary-subtle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                        <i class="ti ti-tag text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Regular Price</small>
                                                        <small class="text-primary" style="font-size: 0.7rem;">Retail</small>
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-primary" style="font-size: 1.5rem;">{{ number_format($product->price, 2) }} EGP</div>
                                            </div>
                                        </div>

                                        @if($product->sale_price > 0)
                                        <div class="col-md-{{ $product->base_price > 0 ? '4' : '6' }}">
                                            <div class="p-3 rounded border position-relative h-100" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
                                                <div class="gap-2 mb-2 d-flex align-items-center">
                                                    <div class="rounded border bg-success-subtle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                        <i class="ti ti-discount-2 text-success"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-success d-block fw-medium" style="font-size: 0.75rem;">Sale Price</small>
                                                        <small class="text-success" style="font-size: 0.7rem;">Save {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%</small>
                                                    </div>
                                                </div>
                                                <div class="fw-bold text-success" style="font-size: 1.5rem;">{{ number_format($product->sale_price, 2) }} EGP</div>
                                                @if($product->price > $product->sale_price)
                                                <small class="mt-1 text-decoration-line-through text-muted d-block">{{ number_format($product->price, 2) }} EGP</small>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    @if($product->sale_price > 0 || $product->base_price > 0)
                                    <div class="mt-3 row g-2">
                                        @if($product->sale_price > 0)
                                        <div class="col-md-6">
                                            <div class="p-2 bg-white rounded border d-flex align-items-center">
                                                <div class="rounded bg-success-subtle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="ti ti-receipt text-success" style="font-size: 1rem;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Customer Savings</small>
                                                    <span class="text-success fw-semibold">{{ number_format($product->price - $product->sale_price, 2) }} EGP</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if($product->base_price > 0)
                                        <div class="col-md-6">
                                            <div class="p-2 bg-white rounded border d-flex align-items-center">
                                                <div class="rounded bg-info-subtle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="ti ti-trending-up text-info" style="font-size: 1rem;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Profit Margin</small>
                                                    <span class="text-info fw-semibold">
                                                        {{ number_format(($product->sale_price > 0 ? $product->sale_price : $product->price) - $product->base_price, 2) }} EGP
                                                        <small class="text-muted">({{ number_format(((($product->sale_price > 0 ? $product->sale_price : $product->price) - $product->base_price) / ($product->sale_price > 0 ? $product->sale_price : $product->price)) * 100, 1) }}%)</small>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Categories -->
                            @if($product->categories->count() > 0)
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">
                                        <i class="ti ti-folder me-2 text-muted"></i>Categories
                                    </h5>
                                    <div class="row g-2">
                                        @php
                                            // Separate main categories and subcategories
                                            $mainCategories = $product->categories->filter(function($cat) {
                                                return $cat->parent_id === null;
                                            });
                                            $subCategories = $product->categories->filter(function($cat) {
                                                return $cat->parent_id !== null;
                                            });
                                        @endphp

                                        @foreach($mainCategories as $category)
                                            <div class="col-12">
                                                <div class="p-2 rounded border bg-light d-flex align-items-center">
                                                    @if($category->getMedia('category_image')->first())
                                                        <img src="{{ $category->getMedia('category_image')->first()->getUrl() }}"
                                                             alt="{{ $category->name }}"
                                                             class="rounded me-2"
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-white rounded border me-2 d-flex align-items-center justify-content-center"
                                                             style="width: 32px; height: 32px;">
                                                            <i class="ti ti-folder text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <span class="fw-medium text-dark">{{ $category->name }}</span>
                                                        @if($category->gender)
                                                            <small class="text-muted d-block">{{ $category->gender->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Show subcategories under this main category --}}
                                                @php
                                                    $categorySubCategories = $subCategories->filter(function($sub) use ($category) {
                                                        return $sub->parent_id === $category->id;
                                                    });
                                                @endphp

                                                @if($categorySubCategories->count() > 0)
                                                    <div class="mt-1 ms-3">
                                                        @foreach($categorySubCategories as $subCategory)
                                                            <div class="p-2 mb-1 bg-white rounded border d-flex align-items-center">
                                                                <i class="ti ti-corner-down-right text-muted me-2" style="font-size: 0.85rem;"></i>
                                                                @if($subCategory->getMedia('category_image')->first())
                                                                    <img src="{{ $subCategory->getMedia('category_image')->first()->getUrl() }}"
                                                                         alt="{{ $subCategory->name }}"
                                                                         class="rounded me-2"
                                                                         style="width: 28px; height: 28px; object-fit: cover;">
                                                                @else
                                                                    <div class="rounded border bg-light me-2 d-flex align-items-center justify-content-center"
                                                                         style="width: 28px; height: 28px;">
                                                                        <i class="ti ti-folder-open text-muted" style="font-size: 0.85rem;"></i>
                                                                    </div>
                                                                @endif
                                                                <span class="text-dark">{{ $subCategory->name }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach

                                        {{-- Show subcategories that don't have their parent in the product --}}
                                        @php
                                            $orphanSubCategories = $subCategories->filter(function($sub) use ($mainCategories) {
                                                return !$mainCategories->contains('id', $sub->parent_id);
                                            });
                                        @endphp

                                        @if($orphanSubCategories->count() > 0)
                                            @foreach($orphanSubCategories as $subCategory)
                                                <div class="col-12">
                                                    <div class="p-2 rounded border bg-light d-flex align-items-center">
                                                        @if($subCategory->getMedia('category_image')->first())
                                                            <img src="{{ $subCategory->getMedia('category_image')->first()->getUrl() }}"
                                                                 alt="{{ $subCategory->name }}"
                                                                 class="rounded me-2"
                                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-white rounded border me-2 d-flex align-items-center justify-content-center"
                                                                 style="width: 32px; height: 32px;">
                                                                <i class="ti ti-folder-open text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            <span class="text-dark">{{ $subCategory->name }}</span>
                                                            @if($subCategory->parent)
                                                                <small class="text-muted d-block">
                                                                    <i class="ti ti-arrow-back-up" style="font-size: 0.75rem;"></i> {{ $subCategory->parent->name }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Tags -->
                            @if($product->tags->count() > 0)
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">
                                        <i class="ti ti-tags me-2 text-muted"></i>Product Tags
                                    </h5>
                                    <div class="flex-wrap gap-2 d-flex">
                                        @foreach($product->tags as $tag)
                                            <div class="px-3 py-2 rounded border bg-light d-inline-flex align-items-center">
                                                <i class="ti ti-tag me-2 text-muted" style="font-size: 0.9rem;"></i>
                                                <span class="text-dark">{{ $tag->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Bundle Items (Bundle Products Only) -->
                            @if($product->type === 'bundle' && $product->bundleItems->count() > 0)
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold"><i class="ti ti-box-multiple me-2 text-success"></i>Bundle Items</h5>
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0">#</th>
                                                    <th class="border-0">Product</th>
                                                    <th class="border-0">Type</th>
                                                    <th class="border-0">Quantity</th>
                                                    <th class="border-0">Options</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($product->bundleItems as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            @if($item->child)
                                                                <div class="d-flex align-items-center">
                                                                    @if($item->child->getMedia('product_thumbnail')->first())
                                                                        <img src="{{ $item->child->getMedia('product_thumbnail')->first()->getUrl() }}"
                                                                             alt="{{ $item->child->name }}"
                                                                             class="rounded me-2"
                                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                                    @else
                                                                        <div class="rounded bg-primary-subtle me-2 d-flex align-items-center justify-content-center"
                                                                             style="width: 40px; height: 40px;">
                                                                            <i class="ti ti-box text-primary"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <div class="fw-semibold">{{ $item->child->name }}</div>
                                                                        <small class="text-muted">{{ $item->child->sku }}</small>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $item->type === 'simple' ? 'bg-info' : 'bg-warning' }}">
                                                                {{ ucfirst($item->type) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $item->qty }}x</span>
                                                        </td>
                                                        <td>
                                                            @if($item->type === 'variant' && $item->options->count() > 0)
                                                                <div class="flex-wrap gap-1 d-flex">
                                                                    @foreach($item->options as $option)
                                                                        @if($option->variant)
                                                                            <span class="px-2 py-1 badge bg-warning-subtle text-warning">
                                                                                {{ $option->variant->name }}
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Attributes & Variants (Variant Products Only) -->
                            @if($product->type === 'variant')
                                <!-- Attributes -->
                                @if($product->attributes->count() > 0)
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <h5 class="mb-3 fw-semibold">Product Attributes</h5>
                                        <div class="row g-3">
                                            @foreach($product->attributes as $attribute)
                                                <div class="col-md-6">
                                                    <label class="mb-2 text-muted fs-sm">{{ $attribute->name }}</label>
                                                    <div class="flex-wrap gap-1 d-flex">
                                                        @foreach($attribute->values as $value)
                                                            <span class="px-2 py-1 border badge bg-light text-dark">{{ $value->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Variants Table -->
                                @if($product->variants->count() > 0)
                                <div class="mb-3 border-0 shadow-sm card">
                                    <div class="card-body">
                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0 fw-semibold">Product Variants</h5>
                                            <span class="badge bg-primary">{{ $product->variants->count() }} Variants</span>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-hover">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="border-0">Variant</th>
                                                        <th class="border-0">SKU</th>
                                                        <th class="border-0">Price</th>
                                                        <th class="border-0">Sale Price</th>
                                                        <th class="border-0">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->variants as $variant)
                                                        <tr>
                                                            <td>
                                                                <div class="fw-semibold">{{ $variant->name }}</div>
                                                                <small class="text-muted">{{ $variant->getVariantName() }}</small>
                                                            </td>
                                                            <td>
                                                                <code class="text-muted">{{ $variant->sku }}</code>
                                                            </td>
                                                            <td class="text-primary fw-bold">{{ number_format($variant->price, 2) }} EGP</td>
                                                            <td>
                                                                @if($variant->sale_price > 0)
                                                                    <span class="text-success fw-bold">{{ number_format($variant->sale_price, 2) }} EGP</span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($variant->is_active)
                                                                    <span class="badge bg-success-subtle text-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endif

                            <!-- SEO Information -->
                            <div class="mb-3 border-0 shadow-sm card">
                                <div class="card-body">
                                    <h5 class="mb-3 fw-semibold">SEO Information</h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="mb-1 text-muted fs-sm">Meta Title</label>
                                            <div class="text-dark">{{ $product->meta_title ?: 'Not set' }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="mb-1 text-muted fs-sm">Meta Description</label>
                                            <div class="text-dark">{{ $product->meta_desc ?: 'Not set' }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="mb-1 text-muted fs-sm">Meta Keywords</label>
                                            <div class="text-dark">{{ $product->meta_keywords ?: 'Not set' }}</div>
                                        </div>
                                        <div class="col-12">
                                            <label class="mb-1 text-muted fs-sm">URL Slug</label>
                                            <div class="text-muted fs-sm">
                                                <code>{{ $product->slug }}</code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Reviews -->
                            <div class="mb-3">
                                @include('admin.pages.reviews.section', ['product' => $product])
                            </div>

                            <!-- Product Questions (FAQ) -->
                            <div class="mb-3">
                                @include('admin.pages.questions.section', ['product' => $product])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.pages.products.deleteModal')
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="border-0 shadow modal-content">
                <div class="p-0 modal-body">
                    <button type="button" class="top-0 m-3 bg-white btn-close position-absolute end-0" data-bs-dismiss="modal" style="z-index: 10;"></button>
                    <img id="modalImage" src="" alt="Preview" class="w-100 img-fluid">
                </div>
            </div>
        </div>
    </div>
    <script>
        function viewImage(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }
    </script>
    <style>
        .badge {
            font-weight: 500;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        code {
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>
</body>
</html>
