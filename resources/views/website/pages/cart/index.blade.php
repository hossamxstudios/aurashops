<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Shopping Cart</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Shopping Cart - Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')

        <!-- page-title -->
        <div class="page-title" style="background-image: url({{ asset('website/images/section/page-title.jpg') }});">
            <div class="pt-5 container-full">
                <div class="pt-5 row">
                    <div class="col-12">
                        <h3 class="text-center heading">Shopping Cart</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                Shopping Cart
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- cart -->
        <section class="flat-spacing">
            <div class="container">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($cart->items->count() > 0)
                    <div class="row">
                        <div class="col-xl-8">
                            {{-- <div class="tf-cart-sold">
                                <div class="notification-progress">
                                    <div class="text">Buy <span class="fw-semibold text-primary">${{ number_format(70 - $cart->items->sum('sub_total'), 2) }}</span> more to get
                                        <span class="fw-semibold">Freeship</span></div>
                                    <div class="progress-cart">
                                        <div class="value" style="width: {{ min(($cart->items->sum('sub_total') / 70) * 100, 100) }}%;" data-progress="50">
                                            <span class="round"></span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <form>
                                <table class="tf-table-page-cart">
                                    <thead>
                                        <tr>
                                            <th>Products</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart->items as $item)
                                            <tr class="tf-cart-item file-delete">
                                                <td class="tf-cart-item_product">
                                                    <a href="{{ route('product.show', $item->product->slug) }}" class="img-box">
                                                        @if($item->variant)
                                                            <img src="{{ $item->variant->getFirstMediaUrl('variant_images') ?: $item->product->getFirstMediaUrl('product_thumbnail') }}"
                                                                 alt="{{ $item->product->name }}">
                                                        @else
                                                            <img src="{{ $item->product->getFirstMediaUrl('product_thumbnail') }}"
                                                                 alt="{{ $item->product->name }}">
                                                        @endif
                                                    </a>
                                                    <div class="cart-info">
                                                        <a href="{{ route('product.show', $item->product->slug) }}" class="cart-title link">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        @if($item->variant)
                                                            <div class="variant-box">
                                                                <p class="mb-0 text-secondary">{{ $item->variant->name }}</p>
                                                            </div>
                                                        @endif
                                                        @if($item->type === 'bundle')
                                                            <p class="mb-0 text-secondary">
                                                                <small>Bundle Product</small>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td data-cart-title="Price" class="text-center tf-cart-item_price">
                                                    <div class="cart-price text-button price-on-sale">${{ number_format($item->price, 2) }}</div>
                                                </td>
                                                <td data-cart-title="Quantity" class="tf-cart-item_quantity">
                                                    <div class="wg-quantity mx-md-auto">
                                                        <span class="btn-quantity btn-decrease" data-item-id="{{ $item->id }}">-</span>
                                                        <input type="text" class="quantity-product" name="number" value="{{ $item->qty }}" data-item-id="{{ $item->id }}">
                                                        <span class="btn-quantity btn-increase" data-item-id="{{ $item->id }}">+</span>
                                                    </div>
                                                </td>
                                                <td data-cart-title="Total" class="text-center tf-cart-item_total">
                                                    <div class="cart-total text-button total-price">${{ number_format($item->sub_total, 2) }}</div>
                                                </td>
                                                <td data-cart-title="Remove" class="remove-cart">
                                                    <button type="button" class="remove icon icon-close" style="border: none; background: none; cursor: pointer;" onclick="removeItem({{ $item->id }}, event); return false;"></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4 cart-action-buttons d-flex justify-content-between align-items-center">
                                    <a href="{{ route('shop.all') }}" class="tf-btn btn-outline">
                                        <span class="icon icon-arrow-left"></span>
                                        <span class="text">Continue Shopping</span>
                                    </a>
                                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline clear-cart-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tf-btn btn-outline btn-danger">
                                            <span class="icon icon-trash"></span>
                                            <span class="text">Clear Cart</span>
                                        </button>
                                    </form>
                                </div>

                                {{-- <div class="ip-discount-code">
                                    <input type="text" placeholder="Add voucher discount">
                                    <button class="tf-btn"><span class="text">Apply Code</span></button>
                                </div>
                                <div class="group-discount">
                                    <div class="box-discount">
                                        <div class="discount-top">
                                            <div class="discount-off">
                                                <div class="text-caption-1">Discount</div>
                                                <span class="sale-off text-btn-uppercase">10% OFF</span>
                                            </div>
                                            <div class="discount-from">
                                                <p class="text-caption-1">For all orders <br> from $200</p>
                                            </div>
                                        </div>
                                        <div class="discount-bot">
                                            <span class="text-btn-uppercase">SAVE10</span>
                                            <button class="tf-btn" type="button"><span class="text">Apply Code</span></button>
                                        </div>
                                    </div>
                                    <div class="box-discount active">
                                        <div class="discount-top">
                                            <div class="discount-off">
                                                <div class="text-caption-1">Discount</div>
                                                <span class="sale-off text-btn-uppercase">15% OFF</span>
                                            </div>
                                            <div class="discount-from">
                                                <p class="text-caption-1">For all orders <br> from $300</p>
                                            </div>
                                        </div>
                                        <div class="discount-bot">
                                            <span class="text-btn-uppercase">SAVE15</span>
                                            <button class="tf-btn" type="button"><span class="text">Apply Code</span></button>
                                        </div>
                                    </div>
                                    <div class="box-discount">
                                        <div class="discount-top">
                                            <div class="discount-off">
                                                <div class="text-caption-1">Discount</div>
                                                <span class="sale-off text-btn-uppercase">20% OFF</span>
                                            </div>
                                            <div class="discount-from">
                                                <p class="text-caption-1">For all orders <br> from $500</p>
                                            </div>
                                        </div>
                                        <div class="discount-bot">
                                            <span class="text-btn-uppercase">SAVE20</span>
                                            <button class="tf-btn" type="button"><span class="text">Apply Code</span></button>
                                        </div>
                                    </div>
                                </div> --}}
                            </form>
                        </div>
                        <div class="col-xl-4">
                            <div class="fl-sidebar-cart">
                                <div class="box-order bg-surface">
                                    <h5 class="title">Order Summary</h5>
                                    <div class="subtotal text-button d-flex justify-content-between align-items-center">
                                        <span>Subtotal</span>
                                        <span class="subtotal-amount">${{ number_format($cart->items->sum('sub_total'), 2) }}</span>
                                    </div>
                                    <div class="shipping-cost text-button d-flex justify-content-between align-items-center">
                                        <span>Shipping Cost</span>
                                        <span class="shipping-amount">$0.00</span>
                                    </div>
                                    <div class="discount text-button d-flex justify-content-between align-items-center">
                                        <span>Discounts</span>
                                        <span class="discount-amount">$0.00</span>
                                    </div>
                                    <div class="ship">
                                        <span class="text-button">Shipping</span>
                                        <div class="flex-grow-1">
                                            <fieldset class="ship-item">
                                                <input type="radio" name="ship-check" class="tf-check-rounded" id="free"
                                                    checked>
                                                <label for="free">
                                                    <span>Free Shipping</span>
                                                    <span class="price">$0.00</span>
                                                </label>
                                            </fieldset>
                                            <fieldset class="ship-item">
                                                <input type="radio" name="ship-check" class="tf-check-rounded" id="local">
                                                <label for="local">
                                                    <span>Local:</span>
                                                    <span class="price">$35.00</span>
                                                </label>
                                            </fieldset>
                                            <fieldset class="ship-item">
                                                <input type="radio" name="ship-check" class="tf-check-rounded" id="rate">
                                                <label for="rate">
                                                    <span>Flat Rate:</span>
                                                    <span class="price">$35.00</span>
                                                </label>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <h5 class="total-order d-flex justify-content-between align-items-center">
                                        <span>Total</span>
                                        <span class="total">${{ number_format($cart->items->sum('sub_total'), 2) }}</span>
                                    </h5>
                                    <div class="box-progress-checkout">
                                        <fieldset class="check-agree">
                                            <input type="checkbox" id="check-agree" class="tf-check-rounded">
                                            <label for="check-agree">
                                                I agree with the <a href="#">terms and conditions</a>
                                            </label>
                                        </fieldset>
                                        <a href="{{ route('checkout.page') }}" class="tf-btn btn-reset">Process To Checkout</a>
                                        <p class="text-center text-button">Or <a href="{{ route('shop.all') }}">continue shopping</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="py-5 text-center empty-cart">
                        <svg width="150" height="150" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-4">
                            <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#ccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h4>Your Cart is Empty</h4>
                        <p class="mb-4 text-secondary">Add some products to get started!</p>
                        <a href="{{ route('shop.all') }}" class="tf-btn btn-fill">
                            <span class="text text-button">Start Shopping</span>
                        </a>
                    </div>
                @endif
            </div>
        </section>
        <!-- /cart -->

        @include('website.main.footer')
    </div>
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')
    @include('website.pages.cart.cart-script')


</body>
</html>
