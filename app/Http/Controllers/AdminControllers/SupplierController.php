<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(20);
        
        return view('admin.pages.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'payment_terms' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Supplier::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'address' => $request->address,
            'website' => $request->website,
            'payment_terms' => $request->payment_terms,
            'currency' => $request->currency,
            'notes' => $request->notes,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'payment_terms' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supplier->update([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'address' => $request->address,
            'website' => $request->website,
            'payment_terms' => $request->payment_terms,
            'currency' => $request->currency,
            'notes' => $request->notes,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully');
    }
}
