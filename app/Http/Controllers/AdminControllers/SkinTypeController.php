<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SkinType;

class SkinTypeController extends Controller {
    /**
     * Display a listing of skin types
     */
    public function index(Request $request){
        $query = SkinType::query();
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('details', 'like', "%{$search}%");
        }
        $skin_types = $query->orderBy('id', 'desc')->paginate(16);
        return view('admin.pages.skin_types.index', compact('skin_types'));
    }

    /**
     * Store a newly created skin type
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:skin_types,name',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.skin-types.index')->withErrors($validator)->withInput();
        }

        $skinType = new SkinType();
        $skinType->name = $request->name;
        $skinType->details = $request->details;
        $skinType->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $skinType->addMediaFromRequest('image')
                ->toMediaCollection('skin_type_image');
        }

        return redirect()->route('admin.skin-types.index')
            ->with('success', 'Skin type created successfully');
    }

    /**
     * Get skin type data for editing
     */
    public function edit($id){
        $skinType = SkinType::findOrFail($id);
        $data = [
            'id' => $skinType->id,
            'name' => $skinType->name,
            'details' => $skinType->details,
            'image_url' => $skinType->getMedia('skin_type_image')->first()?->getUrl(),
        ];
        return response()->json($data);
    }

    /**
     * Update the specified skin type
     */
    public function update(Request $request, $id){
        $skinType = SkinType::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:skin_types,name,' . $id,
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.skin-types.index')
                ->withErrors($validator)
                ->withInput();
        }

        $skinType->name = $request->name;
        $skinType->details = $request->details;
        $skinType->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $skinType->clearMediaCollection('skin_type_image');
            $skinType->addMediaFromRequest('image')
                ->toMediaCollection('skin_type_image');
        }

        return redirect()->route('admin.skin-types.index')
            ->with('success', 'Skin type updated successfully');
    }

    /**
     * Remove the specified skin type
     */
    public function destroy($id){
        $skinType = SkinType::findOrFail($id);
        $skinType->delete();

        return redirect()->route('admin.skin-types.index')
            ->with('success', 'Skin type deleted successfully');
    }
}
