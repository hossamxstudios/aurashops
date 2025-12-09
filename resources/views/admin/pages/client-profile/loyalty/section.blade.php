<div class="row g-3">
    <!-- Loyalty Account Summary -->
    <div class="col-md-12">
        <div class="border-0 shadow-sm card">
            <div class="p-4 card-body">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="ti ti-coins text-warning" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h2 class="mb-1 fw-bold">{{ number_format($client->loyaltyAccount->points ?? 0, 0) }}</h2>
                                    <p class="mb-0 text-muted fs-sm fw-medium">Available Points</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="ti ti-trending-up text-success" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h2 class="mb-1 fw-bold text-success">{{ number_format($client->loyaltyAccount->all_points ?? 0, 0) }}</h2>
                                    <p class="mb-0 text-muted fs-sm fw-medium">Total Earned</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="ti ti-trending-down text-danger" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h2 class="mb-1 fw-bold text-danger">{{ number_format($client->loyaltyAccount->used_points ?? 0, 0) }}</h2>
                                    <p class="mb-0 text-muted fs-sm fw-medium">Points Used</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="gap-2 d-grid">
                            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#addPointsModal">
                                <i class="ti ti-plus me-1"></i>Add Points
                            </button>
                            <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#subtractPointsModal">
                                <i class="ti ti-minus me-1"></i>Subtract Points
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Points History -->
    <div class="col-md-12">
        <div class="border-0 shadow-sm card">
            <div class="p-0 card-body">
                <div class="p-4 border-bottom">
                    <h5 class="mb-0 fw-semibold">Transaction History</h5>
                </div>
                @if($client->loyaltyAccount && $client->loyaltyAccount->logs->count() > 0)
                    <div class="rounded table-responsive">
                        <table class="table mb-0 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-muted fw-medium fs-sm">Date & Time</th>
                                    <th class="border-0 text-muted fw-medium fs-sm">Type</th>
                                    <th class="border-0 text-muted fw-medium fs-sm text-end">Change</th>
                                    <th class="border-0 text-muted fw-medium fs-sm text-end">Balance</th>
                                    <th class="border-0 text-muted fw-medium fs-sm">Notes</th>
                                    <th class="border-0 text-muted fw-medium fs-sm">Expires</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client->loyaltyAccount->logs->sortByDesc('created_at') as $log)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="fw-medium">{{ $log->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td class="align-middle">
                                            @if($log->type == 'earned')
                                                <span class="border-0 badge bg-success fw-medium">Earned</span>
                                            @elseif($log->type == 'redeemed')
                                                <span class="border-0 badge bg-danger fw-medium">Redeemed</span>
                                            @elseif($log->type == 'expired')
                                                <span class="border-0 badge bg-warning fw-medium">Expired</span>
                                            @elseif($log->type == 'manual_add')
                                                <span class="border-0 badge bg-primary fw-medium">Manual Add</span>
                                            @elseif($log->type == 'manual_subtract')
                                                <span class="border-0 badge bg-secondary fw-medium">Manual Subtract</span>
                                            @else
                                                <span class="border-0 badge bg-secondary fw-medium">{{ ucfirst($log->type) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-end">
                                            @if($log->points > 0)
                                                <span class="fw-bold text-success">+{{ number_format($log->points, 0) }}</span>
                                            @else
                                                <span class="fw-bold text-danger">{{ number_format($log->points, 0) }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-end">
                                            <span class="fw-semibold">{{ number_format($log->points_after, 0) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if($log->notes)
                                                <span class="text-muted fs-sm">{{ Str::limit($log->notes, 40) }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if($log->expires_at)
                                                <span class="text-muted fs-sm">{{ $log->expires_at->format('M d, Y') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-5 text-center">
                        <div class="mb-3">
                            <i class="ti ti-history text-muted" style="font-size: 3rem; opacity: 0.15;"></i>
                        </div>
                        <h6 class="text-muted fw-semibold">No Transaction History</h6>
                        <p class="mb-0 text-muted fs-sm">Point transactions will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
