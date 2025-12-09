<div class="card mb-3">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0">
            <i class="ti ti-package me-2"></i>
            Order Items
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->product)
                                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <div class="fw-semibold">{{ $item->product->name }}</div>
                                            @if($item->variant)
                                                <small class="text-muted">{{ $item->variant->name }}</small>
                                            @endif
                                            @if($item->options->isNotEmpty())
                                                <div class="mt-1">
                                                    @foreach($item->options as $option)
                                                        <small class="badge bg-light text-dark">
                                                            @if($option->bundleItem && $option->bundleItem->bundle)
                                                                {{ $option->bundleItem->bundle->name }}:
                                                            @endif
                                                            @if($option->variant)
                                                                {{ $option->variant->name }}
                                                            @endif
                                                            x{{ $option->quantity }}
                                                        </small>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Unknown Product</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <strong>{{ $item->qty }}</strong>
                            </td>
                            <td class="text-end">
                                {{ number_format($item->price, 2) }} EGP
                            </td>
                            <td class="text-end">
                                <strong>{{ number_format($item->subtotal, 2) }} EGP</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No items found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($order->client_notes)
    <div class="card mb-3">
        <div class="card-header bg-light">
            <h6 class="card-title mb-0">
                <i class="ti ti-message me-2"></i>
                Client Notes
            </h6>
        </div>
        <div class="card-body">
            <p class="mb-0">{{ $order->client_notes }}</p>
        </div>
    </div>
@endif
