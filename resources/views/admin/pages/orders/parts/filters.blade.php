<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Order ID, Client Name, Phone" value="{{ request('search') }}">
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div class="col-md-2">
                        <label class="form-label">Payment</label>
                        <select name="payment" class="form-select">
                            <option value="">All</option>
                            <option value="1" {{ request('payment') === '1' ? 'selected' : '' }}>Paid</option>
                            <option value="0" {{ request('payment') === '0' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>

                    <!-- Source Filter -->
                    <div class="col-md-2">
                        <label class="form-label">Source</label>
                        <select name="source" class="form-select">
                            <option value="">All Sources</option>
                            <option value="POS" {{ request('source') == 'POS' ? 'selected' : '' }}>POS</option>
                            <option value="Online" {{ request('source') == 'Online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-2">
                        <label class="form-label">Date From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-2">
                        <label class="form-label">Date To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search me-1"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh me-1"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
