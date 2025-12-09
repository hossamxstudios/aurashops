<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SkinTone;

class SkinToneController extends Controller {
    /**
     * Display a listing of skin tones
     */
    public function index(Request $request){
        $query = SkinTone::query();
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        $skin_tones = $query->orderBy('id', 'desc')->paginate(16);
        return view('admin.pages.skin_tones.index', compact('skin_tones'));
    }

    /**
     * Store a newly created skin tone
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:skin_tones,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.skin-tones.index')->withErrors($validator)->withInput();
        }
        $skinTone = new SkinTone();
        $skinTone->name = $request->name;
        $skinTone->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $skinTone->addMediaFromRequest('image')->toMediaCollection('skin_tone_image');
        }

        return redirect()->route('admin.skin-tones.index')->with('success', 'Skin tone created successfully');
    }

    /**
     * Get skin tone data for editing
     */
    public function edit($id){
        $skinTone = SkinTone::findOrFail($id);
        $data = [
            'id' => $skinTone->id,
            'name' => $skinTone->name,
            'image_url' => $skinTone->getMedia('skin_tone_image')->first()?->getUrl(),
        ];
        return response()->json($data);
    }

    /**
     * Update the specified skin tone
     */
    public function update(Request $request, $id){
        $skinTone = SkinTone::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:skin_tones,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.skin-tones.index')
                ->withErrors($validator)
                ->withInput();
        }
        $skinTone->name = $request->name;
        $skinTone->save();
        // Handle image upload
        if ($request->hasFile('image')) {
            $skinTone->clearMediaCollection('skin_tone_image');
            $skinTone->addMediaFromRequest('image')
                ->toMediaCollection('skin_tone_image');
        }
        return redirect()->route('admin.skin-tones.index')->with('success', 'Skin tone updated successfully');
    }

    /**
     * Remove the specified skin tone
     */
    public function destroy($id){
        $skinTone = SkinTone::findOrFail($id);
        $skinTone->delete();

        return redirect()->route('admin.skin-tones.index')
            ->with('success', 'Skin tone deleted successfully');
    }
}
