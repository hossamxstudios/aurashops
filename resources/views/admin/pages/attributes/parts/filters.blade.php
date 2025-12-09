<div class="mb-3 row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.attributes.index') }}">
                    <div class="row g-2">
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="search" placeholder="Search by name or details..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <div class="gap-2 d-flex">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-search me-1"></i>Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-light">
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
