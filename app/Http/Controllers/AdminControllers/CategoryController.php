<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller {

    public function index(Request $request) {
        // Only get main categories (parent_id is null)
        $query = Category::with(['gender', 'children'])->whereNull('parent_id');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Filter by gender
        if ($request->has('gender_id') && $request->gender_id != '') {
            $query->where('gender_id', $request->gender_id);
        }
        $categories = $query->orderBy('id', 'desc')->paginate(12);
        $genders = Gender::all();
        return view('admin.pages.categories.index', compact('categories', 'genders'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'gender_id' => 'nullable|exists:genders,id',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'gender_id' => $request->gender_id,
            'parent_id' => $request->parent_id,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('category_image');
        }

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $imageUrl = null;
        if ($category->getMedia('category_image')->first()) {
            $imageUrl = $category->getMedia('category_image')->first()->getUrl();
        }

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'gender_id' => $category->gender_id,
            'parent_id' => $category->parent_id,
            'image_url' => $imageUrl,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'gender_id' => 'nullable|exists:genders,id',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'gender_id' => $request->gender_id,
            'parent_id' => $request->parent_id,
        ]);

        // Handle image upload - replace existing
        if ($request->hasFile('image')) {
            $category->clearMediaCollection('category_image');
            $category->addMediaFromRequest('image')->toMediaCollection('category_image');
        }

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
