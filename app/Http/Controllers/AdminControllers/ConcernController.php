<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use Illuminate\Http\Request;

class ConcernController extends Controller {
    
    public function index(Request $request) {
        $query = Concern::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('details', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%');
            });
        }
        
        $concerns = $query->orderBy('id', 'desc')->paginate(12);
        return view('admin.pages.concerns.index', compact('concerns'));
    }

    public function store(Request $request) {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:concerns,name',
            'details' => 'nullable|string',
            'type' => 'required|string|in:skin,hair',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $concern = Concern::create([
            'name' => $request->name,
            'details' => $request->details,
            'type' => $request->type,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $concern->addMediaFromRequest('image')->toMediaCollection('concern_image');
        }

        return redirect()->back()->with('success', 'Concern created successfully');
    }

    public function edit($id) {
        $concern = Concern::findOrFail($id);
        
        $imageUrl = null;
        if ($concern->getMedia('concern_image')->first()) {
            $imageUrl = $concern->getMedia('concern_image')->first()->getUrl();
        }
        
        return response()->json([
            'id' => $concern->id,
            'name' => $concern->name,
            'details' => $concern->details,
            'type' => $concern->type,
            'image_url' => $imageUrl,
        ]);
    }

    public function update(Request $request, $id) {
        $concern = Concern::findOrFail($id);
        
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:concerns,name,' . $id,
            'details' => 'nullable|string',
            'type' => 'required|string|in:skin,hair',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $concern->update([
            'name' => $request->name,
            'details' => $request->details,
            'type' => $request->type,
        ]);

        // Handle image upload - replace existing
        if ($request->hasFile('image')) {
            $concern->clearMediaCollection('concern_image');
            $concern->addMediaFromRequest('image')->toMediaCollection('concern_image');
        }

        return redirect()->back()->with('success', 'Concern updated successfully');
    }

    public function destroy($id) {
        $concern = Concern::findOrFail($id);
        $concern->delete();
        
        return redirect()->back()->with('success', 'Concern deleted successfully');
    }
}
