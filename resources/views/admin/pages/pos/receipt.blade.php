<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            width: 80mm;
            margin: 0 auto;
            padding: 10px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .receipt-info {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .receipt-info div {
            margin-bottom: 3px;
        }
        .items-table {
            width: 100%;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .item-row {
            margin-bottom: 8px;
        }
        .item-name {
            font-weight: bold;
        }
        .item-details {
            display: flex;
            justify-content: space-between;
            margin-top: 2px;
        }
        .totals {
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total-row.grand-total {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }
        .payment-info {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .footer {
            text-align: center;
            font-size: 11px;
        }
        @media print {
            body { width: 80mm; }
            .no-print { display: none !important; }
        }
        .print-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">Print Receipt</button>

    <div class="receipt-header">
        <div class="store-name">{{ config('app.name', 'Store Name') }}</div>
        <div>{{ \App\Models\Setting::where('key', 'address')->first()?->value }}</div>
        <div>Phone: {{ \App\Models\Setting::where('key', 'phone')->first()?->value }}</div>
        <div>Email: {{ \App\Models\Setting::where('key', 'email')->first()?->value }}</div>
    </div>

    <div class="receipt-info">
        <div><strong>RECEIPT</strong></div>
        <div>Order #: {{ $order->id }}</div>
        <div>Date: {{ $order->created_at->format('M d, Y h:i A') }}</div>
        @if($order->client)
            <div>Customer: {{ $order->client?->full_name }}</div>
        @else
            <div>Customer: Walk-in</div>
        @endif
        @if($order->posSession)
            <div>Cashier: {{ $order->posSession?->user?->name }}</div>
        @endif
    </div>

    <div class="items-table">
        @foreach($order->items as $item)
            <div class="item-row">
                <div class="item-name">
                    {{ $item->product?->name ?? 'Product' }}
                    @if($item->variant)
                        - {{ $item->variant?->name }}
                    @endif
                </div>
                <div class="item-details">
                    <span>{{ $item->qty }} x ${{ number_format($item->price, 2) }}</span>
                    <span>${{ number_format($item->subtotal, 2) }}</span>
                </div>

                @if($item->options->count() > 0)
                    <div style="margin-left: 10px; font-size: 10px; color: #666;">
                        Bundle contains:
                        @foreach($item->options as $option)
                            <div>- {{ $option->childProduct?->name ?? '' }}
                            @if($option->childVariant)
                                ({{ $option->childVariant?->name }})
                            @endif
                            x{{ $option->qty }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($order->subtotal_amount, 2) }}</span>
        </div>
        @if($order->discount_amount > 0)
            <div class="total-row">
                <span>Discount:</span>
                <span>-${{ number_format($order->discount_amount, 2) }}</span>
            </div>
        @endif
        @if($order->tax_amount > 0)
            <div class="total-row">
                <span>Tax (14%):</span>
                <span>${{ number_format($order->tax_amount, 2) }}</span>
            </div>
        @endif
        <div class="total-row grand-total">
            <span>TOTAL:</span>
            <span>${{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div class="payment-info">
        <div><strong>PAYMENT DETAILS</strong></div>
        @foreach($order->payments as $payment)
            <div class="total-row">
                <span>{{ $payment->paymentMethod?->name ?? 'Payment' }}:</span>
                <span>${{ number_format($payment->paid, 2) }}</span>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <div style="margin-bottom: 10px;">
            ========================================
        </div>
        <div>Thank you for your purchase!</div>
        <div>Please come again!</div>
        <div style="margin-top: 10px;">
            ========================================
        </div>
        <div style="margin-top: 5px; font-size: 10px;">
            Powered by {{ config('app.name') }} POS
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            // Wait a bit for content to load
            setTimeout(function() {
                // Uncomment to auto-print
                // window.print();
            }, 500);
        };
    </script>
</body>
</html>
