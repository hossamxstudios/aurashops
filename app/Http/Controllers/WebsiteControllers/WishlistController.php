<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display wishlist page
     */
    public function index()
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')
                ->with('error', 'Please login to view your wishlist');
        }

        $client = Auth::guard('client')->user();

        $wishlistItems = Wishlist::where('client_id', $client->id)
            ->with(['product' => function($query) {
                $query->where('is_active', 1);
            }])
            ->get()
            ->filter(function($item) {
                return $item->product !== null;
            });

        return view('website.pages.wishlist.index', compact('client', 'wishlistItems'));
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // Check if product is active
        $product = Product::where('id', $request->product_id)
            ->where('is_active', 1)
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found or not available'
            ], 404);
        }

        // Check if already in wishlist
        $exists = Wishlist::where('client_id', Auth::guard('client')->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ]);
        }

        // Add to wishlist
        $wishlist = Wishlist::create([
            'client_id' => Auth::guard('client')->id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlist_item' => [
                'id' => $wishlist->id,
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->sale_price > 0 ? $product->sale_price : $product->price,
                'image' => $product->getFirstMediaUrl('product_thumbnail'),
            ]
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy($productId)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $deleted = Wishlist::where('client_id', Auth::guard('client')->id())
            ->where('product_id', $productId)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in wishlist'
        ], 404);
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first',
                'requires_auth' => true
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlistItem = Wishlist::where('client_id', Auth::guard('client')->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();

            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Removed from wishlist'
            ]);
        } else {
            // Add to wishlist
            $product = Product::where('id', $request->product_id)
                ->where('is_active', 1)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not available'
                ], 404);
            }

            Wishlist::create([
                'client_id' => Auth::guard('client')->id(),
                'product_id' => $request->product_id
            ]);

            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Added to wishlist'
            ]);
        }
    }

    /**
     * Check if products are in wishlist
     */
    public function check(Request $request)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'success' => true,
                'in_wishlist' => []
            ]);
        }

        $productIds = $request->input('product_ids', []);

        $wishlistItems = Wishlist::where('client_id', Auth::guard('client')->id())
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'in_wishlist' => $wishlistItems
        ]);
    }
}
