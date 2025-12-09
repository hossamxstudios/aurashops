<div class="pt-2 mb-3 row">
    <div class="col-lg-12">
        <form action="{{ route('admin.skin-types.index') }}" method="GET" class="p-3 rounded border shadow-sm">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <div class="app-search">
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search skin types by name or details...">
                        <i data-lucide="search" class="app-search-icon text-muted"></i>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search me-1"></i>Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.skin-types.index') }}" class="btn btn-light">
                                <i class="ti ti-x me-1"></i>Clear
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
