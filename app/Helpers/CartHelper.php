<?php

namespace App\Helpers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartHelper
{
    /**
     * Get the current user's cart (authenticated or guest)
     *
     * @return Cart|null
     */
    public static function getCurrentCart()
    {
        if (Auth::guard('client')->check()) {
            return Cart::with([
                'items.product',
                'items.variant',
                'items.options.childProduct',
                'items.options.childVariant'
            ])->where('client_id', Auth::guard('client')->user()->id)->first();
        }

        return Cart::with([
            'items.product',
            'items.variant',
            'items.options.childProduct',
            'items.options.childVariant'
        ])->where('session_id', session()->get('cart_session_id'))->first();
    }
}
