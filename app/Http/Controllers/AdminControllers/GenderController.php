<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenderController extends Controller
{
    public function index(Request $request)
    {
        $query = Gender::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }

        $genders = $query->orderBy('id', 'desc')->paginate(12);
        return view('admin.pages.genders.index', compact('genders'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:genders,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gender = Gender::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $gender->addMediaFromRequest('image')->toMediaCollection('gender_image');
        }

        return redirect()->back()->with('success', 'Gender created successfully');
    }

    public function edit($id)
    {
        $gender = Gender::findOrFail($id);

        $imageUrl = null;
        if ($gender->getMedia('gender_image')->first()) {
            $imageUrl = $gender->getMedia('gender_image')->first()->getUrl();
        }

        return response()->json([
            'id' => $gender->id,
            'name' => $gender->name,
            'image_url' => $imageUrl,
        ]);
    }

    public function update(Request $request, $id)
    {
        $gender = Gender::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:genders,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gender->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Handle image upload - replace existing
        if ($request->hasFile('image')) {
            $gender->clearMediaCollection('gender_image');
            $gender->addMediaFromRequest('image')->toMediaCollection('gender_image');
        }

        return redirect()->back()->with('success', 'Gender updated successfully');
    }

    public function destroy($id)
    {
        $gender = Gender::findOrFail($id);
        $gender->delete();

        return redirect()->back()->with('success', 'Gender deleted successfully');
    }
}
