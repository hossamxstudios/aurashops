<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.categories.index') }}">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="search" placeholder="Search by name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
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
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-search me-1"></i>Search
                                </button>
                                @if(request('search') || request('gender_id'))
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
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
