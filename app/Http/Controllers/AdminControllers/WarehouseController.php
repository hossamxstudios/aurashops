<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(20);
        
        return view('admin.pages.warehouses.index', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Warehouse::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse created successfully');
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return response()->json($warehouse);
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $warehouse->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? false,
        ]);

        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse updated successfully');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse deleted successfully');
    }
}
