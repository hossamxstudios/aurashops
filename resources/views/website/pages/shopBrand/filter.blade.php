   <!-- Filter -->
    <div class="offcanvas offcanvas-start canvas-filter" id="filterShop">
        <div class="canvas-wrapper">
            <form method="GET" action="{{ route('shop.all') }}" id="filterForm">
                <div class="canvas-header">
                    <h5>Filters</h5>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
                </div>
                <div class="canvas-body">
                    <!-- Categories Filter -->
                    <div class="widget-facet facet-categories">
                        <h6 class="facet-title">Product Categories</h6>
                        <div class="box-fieldset-item">
                            @foreach($allCategories as $category)
                                <fieldset class="fieldset-item">
                                    <input type="checkbox"
                                           name="categories[]"
                                           value="{{ $category->id }}"
                                           class="tf-check filter-checkbox"
                                           id="category-{{ $category->id }}"
                                           {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                    <label for="category-{{ $category->id }}">
                                        {{ $category->name }}
                                        <span class="count-brand">({{ $category->products()->where('is_active', 1)->count() }})</span>
                                    </label>
                                </fieldset>

                                @if($category->children->count() > 0)
                                    <div class="subcategories" style="margin-left: 20px;">
                                        @foreach($category->children as $subcategory)
                                            <fieldset class="fieldset-item">
                                                <input type="checkbox"
                                                       name="categories[]"
                                                       value="{{ $subcategory->id }}"
                                                       class="tf-check filter-checkbox"
                                                       id="category-{{ $subcategory->id }}"
                                                       {{ in_array($subcategory->id, request('categories', [])) ? 'checked' : '' }}>
                                                <label for="category-{{ $subcategory->id }}">
                                                    {{ $subcategory->name }}
                                                    <span class="count-brand">({{ $subcategory->products()->where('is_active', 1)->count() }})</span>
                                                </label>
                                            </fieldset>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Brands Filter -->
                    <div class="widget-facet facet-fieldset">
                        <h6 class="facet-title">Brands</h6>
                        <div class="box-fieldset-item">
                            @foreach($brands as $brand)
                                <fieldset class="fieldset-item">
                                    <input type="checkbox"
                                           name="brands[]"
                                           value="{{ $brand->id }}"
                                           class="tf-check filter-checkbox"
                                           id="brand-{{ $brand->id }}"
                                           {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                    <label for="brand-{{ $brand->id }}">
                                        {{ $brand->name }}
                                        <span class="count-brand">({{ $brand->products()->where('is_active', 1)->count() }})</span>
                                    </label>
                                </fieldset>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="canvas-bottom">
                    <button type="submit" class="mb-3 tf-btn btn-fill w-100">Apply Filters</button>
                    <a href="{{ route('shop.all') }}" class="tf-btn btn-reset w-100">Reset Filters</a>
                </div>
            </form>
        </div>
    </div>
    <!-- /Filter -->

    <script>
        // Auto-submit form when checkbox changes
        document.querySelectorAll('.filter-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
