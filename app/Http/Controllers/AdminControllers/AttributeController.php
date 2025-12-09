<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Value;

class AttributeController extends Controller {

    public function index() {
        $attributes = Attribute::all();
        return view('admin.pages.attributes.index', compact('attributes'));
    }

    public function store(Request $request) {
         $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attribute = Attribute::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Create attribute values if provided
        if ($request->has('values') && is_array($request->values)) {
            foreach ($request->values as $valueName) {
                if (!empty(trim($valueName))) {
                    $attribute->values()->create([
                        'name' => trim($valueName),
                        'is_active' => 1,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Attribute created successfully');
    }

    public function edit($id){
        $attribute = Attribute::with('values')->findOrFail($id);
        return response()->json([
            'id' => $attribute->id,
            'name' => $attribute->name,
            'is_active' => $attribute->is_active,
            'values' => $attribute->values->map(function($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                ];
            }),
        ]);
    }
    public function update(Request $request, $id) {
        $attribute = Attribute::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:255',
            'value_ids' => 'nullable|array',
            'value_ids.*' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attribute->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Handle attribute values
        if ($request->has('values') && is_array($request->values)) {
            $valueIds = $request->value_ids ?? [];
            $existingValueIds = [];

            foreach ($request->values as $index => $valueName) {
                if (!empty(trim($valueName))) {
                    $valueId = $valueIds[$index] ?? null;

                    if ($valueId && !empty($valueId)) {
                        // Update existing value
                        $value = $attribute->values()->find($valueId);
                        if ($value) {
                            $value->update(['name' => trim($valueName)]);
                            $existingValueIds[] = $valueId;
                        }
                    } else {
                        // Create new value
                        $newValue = $attribute->values()->create([
                            'name' => trim($valueName),
                            'is_active' => 1,
                        ]);
                        $existingValueIds[] = $newValue->id;
                    }
                }
            }

            // Delete values that were removed
            $attribute->values()->whereNotIn('id', $existingValueIds)->delete();
        }

        return redirect()->back()->with('success', 'Attribute updated successfully');
    }

    public function destroy($id) {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return redirect()->back()->with('success', 'Attribute deleted successfully');
    }
}
