<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    /**
     * Store a newly created review (from product page)
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'client_id' => 'nullable|exists:clients,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Review::create([
            'product_id' => $request->product_id,
            'client_id' => $request->client_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return redirect()->back()->with('success', 'Review added successfully');
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, $id){
        $review = Review::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return redirect()->back()->with('success', 'Review updated successfully');
    }

    /**
     * Remove the specified review
     */
    public function destroy($id){
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully');
    }

    /**
     * Get review for editing (AJAX)
     */
    public function edit($id){
        $review = Review::with(['client', 'product'])->findOrFail($id);
        return response()->json($review);
    }
}
