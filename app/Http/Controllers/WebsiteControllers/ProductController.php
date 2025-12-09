<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Gender;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ProductController extends Controller {

    // public function __construct() {
    //     $this->middleware('auth:client')->only('productShow');
    // }

    public function productShow(Request $request, $slug) {
        $product = Product::where('slug', $slug)->where('is_active', 1)->with([
            'brand',
            'gender',
            'categories',
            'variants.values.attribute',
            'bundleItems.child.variants.values.attribute',
            'reviews' => function($query) {
                $query->with('client')->latest();
            }
        ])->firstOrFail();
        // Calculate review statistics
        $reviewsCollection = $product->reviews;
        $totalReviews = $reviewsCollection->count();
        $averageRating = $totalReviews > 0 ? round($reviewsCollection->avg('rating'), 1) : 0;
        // Calculate rating distribution
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviewsCollection->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            $distribution[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 2)
            ];
        }
        // Set all stats at once
        $product->reviewStats = [
            'average' => $averageRating,
            'total' => $totalReviews,
            'distribution' => $distribution
        ];
        // Get related products (same category, limit 8, exclude current product)
        $relatedProducts = Product::where('is_active', 1)->where('id', '!=', $product->id)
            ->whereHas('categories', function($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->inRandomOrder()->limit(8)->get();

        return view('website.pages.product.index', compact('product', 'relatedProducts'));
    }

}
