<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->paginate(20);

        return view('admin.pages.payment_methods.index', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'details' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'slug' => PaymentMethod::generateSlug($request->name),
            'details' => $request->details,
            'is_active' => $request->is_active ?? true,
        ]);

        // Handle icon upload using Spatie Media Library
        if ($request->hasFile('icon')) {
            $paymentMethod->addMediaFromRequest('icon')
                ->toMediaCollection('icon');
        }

        return redirect()->route('admin.payment-methods.index')->with('success', 'Payment method created successfully');
    }

    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        
        // Add icon URL to response
        $paymentMethod->icon_url = $paymentMethod->getFirstMediaUrl('icon');
        
        return response()->json($paymentMethod);
    }

    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $id,
            'details' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $paymentMethod->update([
            'name' => $request->name,
            'slug' => PaymentMethod::generateSlug($request->name),
            'details' => $request->details,
            'is_active' => $request->is_active ?? false,
        ]);

        // Handle icon upload using Spatie Media Library (replaces old icon if exists)
        if ($request->hasFile('icon')) {
            $paymentMethod->clearMediaCollection('icon');
            $paymentMethod->addMediaFromRequest('icon')
                ->toMediaCollection('icon');
        }

        return redirect()->route('admin.payment-methods.index')->with('success', 'Payment method updated successfully');
    }

    public function destroy($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')->with('success', 'Payment method deleted successfully');
    }
}
