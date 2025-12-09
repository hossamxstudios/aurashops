@if($cart && $cart->items && $cart->items->count() > 0)
    @foreach($cart->items as $item)
    <div class="tf-mini-cart-item file-delete" data-cart-item-id="{{ $item->id }}">
        <div class="tf-mini-cart-image">
            <img class="lazyload" data-src="{{ $item->product->getFirstMediaUrl('product_thumbnail') }}"
                src="{{ $item->product->getFirstMediaUrl('product_thumbnail') }}" alt="">
        </div>
        <div class="tf-mini-cart-info flex-grow-1">
            <div class="flex-wrap gap-12 mb_12 d-flex align-items-center justify-content-between">
                <div class="text-title"><a href="{{ route('product.show', $item->product->slug) }}"
                        class="link text-line-clamp-1">{{ $item->product->name }}</a></div>
                <div class="text-button tf-btn-remove remove"
                     data-item-id="{{ $item->id }}"
                     style="cursor: pointer;">Remove</div>
            </div>
            <div class="gap-8 d-flex flex-column">
                @if($item->product->isVariant())
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-secondary-2">{{ $item->variant?->name }}</div>
                        <div class="text-button">{{ $item->qty }} X {{ $item->price }}</div>
                    </div>
                @elseif($item->product->isBundle())
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-secondary-2 fw-5">Bundle includes:</div>
                        <div class="text-button">{{ $item->qty }} X {{ $item->price }}</div>
                    </div>
                    @if($item->options && $item->options->count() > 0)
                        @foreach($item->options as $option)
                            <div class="text-caption-1 text-secondary ps-3">
                                <i class="icon-check" style="font-size: 10px;"></i>
                                {{ $option->childProduct?->name }}
                                @if($option->childVariant)
                                    <span class="fw-5">({{ $option->childVariant->name }})</span>
                                @endif
                            </div>
                        @endforeach
                    @endif
                @else
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-secondary-2">Simple Product</div>
                        <div class="text-button">{{ $item->qty }} X {{ $item->price }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="py-5 text-center">
        <p class="text-secondary">Your cart is empty</p>
    </div>
@endif
