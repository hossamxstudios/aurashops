<div class="mb-3 row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.products.index') }}">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="Search by name, SKU, or details..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="simple" {{ request('type') == 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="variant" {{ request('type') == 'variant' ? 'selected' : '' }}>Variant</option>
                                <option value="bundle" {{ request('type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="brand_id">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="gender_id">
                                <option value="">All Genders</option>
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->id }}" {{ request('gender_id') == $gender->id ? 'selected' : '' }}>
                                        {{ $gender->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="gap-2 d-flex">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-search me-1"></i>Search
                                </button>
                                @if(request('search') || request('type') || request('brand_id') || request('gender_id'))
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                                        <i class="ti ti-x"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
