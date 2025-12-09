<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index()
    {
        $orderStatuses = OrderStatus::latest()->paginate(20);
        
        return view('admin.pages.order_statuses.index', compact('orderStatuses'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:order_statuses,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        OrderStatus::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.order-statuses.index')->with('success', 'Order status created successfully');
    }

    public function edit($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        return response()->json($orderStatus);
    }

    public function update(Request $request, $id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:order_statuses,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $orderStatus->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.order-statuses.index')->with('success', 'Order status updated successfully');
    }

    public function destroy($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        $orderStatus->delete();

        return redirect()->route('admin.order-statuses.index')->with('success', 'Order status deleted successfully');
    }
}
