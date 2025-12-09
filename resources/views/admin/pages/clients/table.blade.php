<div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">
    @foreach ($clients as $client)
        <div class="col">
            <div class="card card-hovered {{ $client->is_blocked ? 'border-danger border-2' : '' }}">
                <div class="card-body">
                    <div class="mb-4 d-flex align-items-center">
                        <div class="me-3 position-relative">
                            @if ($client->getMedia('profile')?->first()?->getUrl())
                                <img src="{{ $client->getMedia('profile')?->first()?->getUrl() }}" alt="avatar" class="rounded-circle" width="72" height="72">
                            @else
                                <img src="{{ asset('admin/assets/images/users/user-1.jpg') }}" alt="avatar" class="rounded-circle" width="72" height="72">
                            @endif
                            <span class="bottom-0 p-1 shadow-sm position-absolute end-0 badge bg-primary rounded-circle" title="Rating 4.8">
                                <i class="text-white ti ti-star"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-1 d-flex align-items-center">
                                <a href="#!" class="link-reset fw-medium fs-md">{{ $client->full_name }}</a>
                                @if($client->is_blocked)
                                    <span class="badge bg-danger ms-2">
                                        <i class="ti ti-ban me-1"></i>Blocked
                                    </span>
                                @endif
                                <img src="{{ asset('admin/assets/images/flags/us.svg') }}" alt="USA" class="ms-2 rounded-circle" height="16">
                            </h5>
                            <p class="mb-1 text-muted">{{ $client->email }}</p>
                            <p class="mb-1 text-muted">{{ $client->phone ?? 'N/A' }}</p>
                            @if($client->gender == 'Male')
                                <span class="badge fw-medium" style="background: rgb(95, 121, 255); color: white">Male</span>
                            @elseif($client->gender == 'Female')
                                <span class="badge fw-medium" style="background: rgb(223, 124, 140); color: white">Female</span>
                            @else
                                <span class="badge fw-medium" style="background: rgb(95, 121, 255); color: white">{{ $client->gender ?? 'N/A' }}</span>
                            @endif
                        </div>
                        <div class="ms-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-icon btn-ghost-light text-muted" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical fs-xl"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="editClient({{ $client->id }})"><i class="ti ti-edit me-2 fs-15"></i>Edit</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="blockClient({{ $client->id }}, '{{ $client->full_name }}', {{ $client->is_blocked ? 'true' : 'false' }})"><i class="ti ti-ban me-2 fs-15"></i>{{ $client->is_blocked ? 'Unblock' : 'Block' }}</a></li>
                                    <li><a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteClient({{ $client->id }}, '{{ $client->full_name }}')"><i class="ti ti-trash me-2 fs-15"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.clients.profile', $client->id) }}" class="icon-link icon-link-hover link-reset fw-medium"> View Profile <i class="bi fs-16 ti ti-arrow-narrow-right"></i> </a>
                </div>
                <div class="card-footer">
                    <div class="text-center row">
                        <div class="col-4">
                            <div class="mb-1 text-muted fs-xs">Orders</div>
                            <div class="fw-bold">76</div>
                        </div>
                        <div class="col-4">
                            <div class="mb-1 text-muted fs-xs">Reviews</div>
                            <div class="fw-bold">335</div>
                        </div>
                        <div class="col-4">
                            <div class="mb-1 text-muted fs-xs">Points</div>
                            <div class="fw-bold">97</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<ul class="pagination pagination-rounded pagination-boxed justify-content-center">
    {{ $clients->links() }}
</ul>
