<div class="py-1 pt-4 row justify-content-center">
    <div class="text-center col-xxl-5 col-xl-7">
        <button class="px-2 py-1 mb-2 shadow badge badge-default fw-normal fst-italic fs-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i data-lucide="plus" class="fs-sm me-1"></i> New Setting
        </button>
        <h3 class="fw-bold">Application Settings</h3>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.settings.index') }}">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Search by key or value..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-lucide="search" class="icon-sm me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary w-100">
                        <i data-lucide="x" class="icon-sm me-1"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Type</th>
                        <th>Public</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $setting)
                        <tr>
                            <td><strong>#{{ $setting->id }}</strong></td>
                            <td><span class="badge bg-secondary">{{ $setting->category }}</span></td>
                            <td><code>{{ $setting->key }}</code></td>
                            <td>
                                @if($setting->type === 'boolean')
                                    <span class="badge {{ $setting->value == '1' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $setting->value == '1' ? 'Yes' : 'No' }}
                                    </span>
                                @else
                                    {{ Str::limit($setting->value, 40) }}
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $setting->type }}</small></td>
                            <td>
                                @if($setting->is_public)
                                    <i data-lucide="eye" class="icon-sm text-success" title="Public"></i>
                                @else
                                    <i data-lucide="eye-off" class="icon-sm text-muted" title="Private"></i>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" onclick="editSetting({{ $setting->id }})" title="Edit">
                                        <i data-lucide="edit" class="icon-sm"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" onclick="deleteSetting({{ $setting->id }}, '{{ $setting->key }}')" title="Delete">
                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i data-lucide="inbox" class="icon-lg mb-2" style="opacity: 0.3;"></i>
                                <p class="mb-0">No settings found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $settings->links() }}
        </div>
    </div>
</div>

@include('admin.pages.settings.createModal')
@include('admin.pages.settings.editModal')
@include('admin.pages.settings.deleteModal')

<style>
    .btn-group .btn {border-radius: 0;}
    .btn-group .btn:first-child {border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;}
    .btn-group .btn:last-child {border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;}
</style>

<script>
    function editSetting(id) {
        fetch(`/admin/settings/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editForm').action = `/admin/settings/${id}`;
                document.getElementById('edit_category').value = data.category;
                document.getElementById('edit_type').value = data.type;
                document.getElementById('edit_key').value = data.key;
                document.getElementById('edit_value').value = data.value || '';
                document.getElementById('edit_details').value = data.details || '';
                document.getElementById('edit_is_public').checked = data.is_public;
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
    }

    function deleteSetting(id, key) {
        document.getElementById('deleteSettingKey').textContent = key;
        document.getElementById('deleteForm').action = `/admin/settings/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
