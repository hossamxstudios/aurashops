<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\ReturnReason;
use Illuminate\Http\Request;

class ReturnReasonController extends Controller
{
    /**
     * Display a listing of return reasons
     */
    public function index()
    {
        $returnReasons = ReturnReason::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.return-reasons.index', compact('returnReasons'));
    }

    /**
     * Store a newly created return reason
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:return_reasons,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ReturnReason::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.return-reasons.index')->with('success', 'Return reason created successfully');
    }

    /**
     * Get return reason for editing (AJAX)
     */
    public function edit($id)
    {
        $returnReason = ReturnReason::findOrFail($id);
        return response()->json($returnReason);
    }

    /**
     * Update the specified return reason
     */
    public function update(Request $request, $id)
    {
        $returnReason = ReturnReason::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:return_reasons,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $returnReason->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.return-reasons.index')->with('success', 'Return reason updated successfully');
    }

    /**
     * Remove the specified return reason
     */
    public function destroy($id)
    {
        $returnReason = ReturnReason::findOrFail($id);
        $returnReason->delete();

        return redirect()->route('admin.return-reasons.index')->with('success', 'Return reason deleted successfully');
    }
}
