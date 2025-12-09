<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get authenticated client if exists (null if not logged in)
            $clientId = Auth::guard('client')->check() ? Auth::guard('client')->id() : null;

            // Create the review
            $review = Review::create([
                'client_id' => $clientId,
                'product_id' => $request->product_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // Load client relationship
            $review->load('client');

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your review has been submitted successfully.',
                'review' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'name' => $review->client?->name ?? 'Anonymous',
                    'created_at' => $review->created_at->diffForHumans(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit review. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reviews for a product
     */
    public function getProductReviews($productId)
    {
        try {
            $product = Product::findOrFail($productId);

            $reviews = $product->reviews()
                ->with('client')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'name' => $review->client?->name ?? 'Anonymous',
                        'created_at' => $review->created_at->diffForHumans(),
                    ];
                });

            // Calculate average rating
            $averageRating = $product->reviews()->avg('rating');
            $totalReviews = $product->reviews()->count();

            // Calculate rating distribution
            $ratingDistribution = [];
            for ($i = 5; $i >= 1; $i--) {
                $count = $product->reviews()->where('rating', $i)->count();
                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                $ratingDistribution[$i] = [
                    'count' => $count,
                    'percentage' => round($percentage, 2)
                ];
            }

            return response()->json([
                'success' => true,
                'reviews' => $reviews,
                'statistics' => [
                    'average' => round($averageRating, 1),
                    'total' => $totalReviews,
                    'distribution' => $ratingDistribution
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load reviews.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
