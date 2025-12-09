<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons
     */
    public function index(Request $request)
    {
        $query = Coupon::query();

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                  ->orWhere('details', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        // Filter by discount type
        if ($request->has('discount_type') && $request->discount_type != '') {
            $query->where('discount_type', $request->discount_type);
        }

        $coupons = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pages.coupons.index', compact('coupons'));
    }

    /**
     * Store a newly created coupon
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'code' => 'required|string|unique:coupons,code',
            'details' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|integer|min:0',
            'max_discount_value' => 'nullable|integer|min:0',
            'usage_limit' => 'required|integer|min:1',
            'usage_limit_client' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'products' => 'nullable|array',
            'categories' => 'nullable|array',
            'brands' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Coupon::create([
            'code' => strtoupper($request->code),
            'details' => $request->details,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value ?? 0,
            'max_discount_value' => $request->max_discount_value ?? 0,
            'usage_limit' => $request->usage_limit,
            'usage_limit_client' => $request->usage_limit_client,
            'used_times' => 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'products' => $request->products ?? null,
            'categories' => $request->categories ?? null,
            'brands' => $request->brands ?? null,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully');
    }

    /**
     * Display the specified coupon with usages
     */
    public function show($id)
    {
        $coupon = Coupon::with(['usages.client', 'usages.order'])->findOrFail($id);
        
        return view('admin.pages.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified coupon
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        
        return response()->json($coupon);
    }

    /**
     * Update the specified coupon
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'code' => 'required|string|unique:coupons,code,' . $id,
            'details' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|integer|min:0',
            'max_discount_value' => 'nullable|integer|min:0',
            'usage_limit' => 'required|integer|min:1',
            'usage_limit_client' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'products' => 'nullable|array',
            'categories' => 'nullable|array',
            'brands' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $coupon->update([
            'code' => strtoupper($request->code),
            'details' => $request->details,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value ?? 0,
            'max_discount_value' => $request->max_discount_value ?? 0,
            'usage_limit' => $request->usage_limit,
            'usage_limit_client' => $request->usage_limit_client,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'products' => $request->products ?? null,
            'categories' => $request->categories ?? null,
            'brands' => $request->brands ?? null,
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully');
    }

    /**
     * Remove the specified coupon
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully');
    }

    /**
     * Generate random coupon code
     */
    public function generateCode()
    {
        $code = strtoupper(Str::random(8));
        
        // Ensure uniqueness
        while (Coupon::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }
        
        return response()->json(['code' => $code]);
    }
}
