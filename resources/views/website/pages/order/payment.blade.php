<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Complete Payment</title>
    <meta name="title" content="Complete Payment - Aura">
    <meta name="description" content="Complete Payment - Aura Beauty Care">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')

        {{-- Page Header --}}

        <div class="tf-page-title">
            <div class="container-full">
                <div class="text-center heading">Complete Payment</div>
            </div>
        </div>

        <section class="flat-spacing-11">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6">
                {{-- Order Summary Card --}}
                <div class="mb-4 card" style="border: 1px solid #ddd;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Order ID:</strong> #{{ $order->id }}</p>
                        <p class="mb-2"><strong>Total Amount:</strong>
                            <span class="text-primary h4">{{ number_format($order->total_amount, 2) }} EGP</span>
                        </p>
                        <p class="mb-0"><strong>Items:</strong> {{ $order->items->sum('qty') }} item(s)</p>
                    </div>
                </div>

                {{-- Payment Gateway Placeholder --}}
                <div class="card" style="border: 2px dashed #007bff;">
                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0 text-center">
                            <i class="icon-credit-card"></i> Payment Gateway Integration
                        </h5>
                    </div>
                    <div class="text-center card-body" style="padding: 3rem 2rem;">
                        <div class="alert alert-info">
                            <i class="icon-info-circle" style="font-size: 48px;"></i>
                            <h4 class="mt-3">Payment Gateway Placeholder</h4>
                            <p class="mb-0">This is where the payment gateway integration will be implemented.</p>
                        </div>

                        <div class="my-4">
                            <h6>Expected Integration Steps:</h6>
                            <ul class="text-start" style="max-width: 400px; margin: 0 auto;">
                                <li>✓ Integrate payment provider (Stripe, PayPal, Fawry, etc.)</li>
                                <li>✓ Process payment securely</li>
                                <li>✓ Handle payment success/failure callbacks</li>
                                <li>✓ Update order payment status</li>
                                <li>✓ Send payment confirmation email</li>
                            </ul>
                        </div>

                        <div class="pt-4 mt-4 border-top">
                            <h6 class="text-danger">⚠️ Important Notice</h6>
                            <p class="text-muted">
                                Your order has been placed successfully but payment processing is not yet implemented.
                                <br>Please contact our support team to complete your payment.
                            </p>
                            <div class="mt-3">
                                <p class="mb-1"><strong>Support Email:</strong> support@example.com</p>
                                <p class="mb-0"><strong>Support Phone:</strong> +20 XXX XXX XXXX</p>
                            </div>
                        </div>

                        {{-- TODO: Replace with actual payment form --}}
                        <div class="p-4 mt-4 rounded bg-light">
                            <code style="color: #d63384;">
                                // TODO: Add payment gateway integration here<br>
                                // Example: Stripe, PayPal, Fawry, Paymob, etc.<br>
                                // This requires backend integration with payment provider
                            </code>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('order.success', $order->id) }}" class="w-auto tf-btn btn-fill radius-4">
                                <span class="text">View Order Invoice</span>
                            </a>
                            <a href="{{ route('home') }}" class="w-auto tf-btn btn-outline radius-4 ms-2">
                                <span class="text">Back to Home</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Payment Info --}}
                <div class="mt-4 alert alert-warning">
                    <h6>📝 For Development Reference:</h6>
                    <p class="mb-2 small">When implementing the payment gateway, you'll need to:</p>
                    <ol class="mb-0 small">
                        <li>Choose a payment provider (Stripe, PayPal, Paymob, Fawry, etc.)</li>
                        <li>Install their SDK/package: <code>composer require stripe/stripe-php</code></li>
                        <li>Add API keys to <code>.env</code> file</li>
                        <li>Create payment intent/session in controller</li>
                        <li>Add payment form with provider's SDK</li>
                        <li>Handle webhooks for payment confirmation</li>
                        <li>Update order status: <code>$order->update(['is_paid' => true]);</code></li>
                        <li>Create OrderPayment record</li>
                        <li>Send confirmation email to customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

        @include('website.main.footer')
    </div>

    @include('website.main.scripts')
</body>
</html>

<style>
    .card code {
        display: block;
        text-align: left;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 4px;
    }
</style>
