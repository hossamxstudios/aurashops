<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Models\Product;

class VariantController extends Controller
{
    public function edit($id)
    {
        $variant = Variant::with('values')->findOrFail($id);
        
        return response()->json([
            'id' => $variant->id,
            'name' => $variant->name,
            'sku' => $variant->sku,
            'price' => $variant->price,
            'sale_price' => $variant->sale_price,
            'is_active' => $variant->is_active,
            'meta_title' => $variant->meta_title,
            'meta_desc' => $variant->meta_desc,
            'meta_keywords' => $variant->meta_keywords,
        ]);
    }

    public function update(Request $request, $id)
    {
        $variant = Variant::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_desc' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $variant->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'sale_price' => $request->sale_price ?: 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'meta_title' => $request->meta_title,
            'meta_desc' => $request->meta_desc,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Variant updated successfully',
            'variant' => $variant
        ]);
    }

    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);
        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variant deleted successfully'
        ]);
    }
}
