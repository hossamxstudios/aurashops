<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('details', 'like', '%' . $search . '%');
        }

        $brands = $query->orderBy('id', 'desc')->paginate(12);
        return view('admin.pages.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:brands,name',
            'details' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $brand = Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'details' => $request->details,
            'website' => $request->website,
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $brand->addMediaFromRequest('logo')->toMediaCollection('brand_logo');
        }

        return redirect()->back()->with('success', 'Brand created successfully');
    }

    public function edit($id){
        $brand = Brand::findOrFail($id);
        $logoUrl = null;
        if ($brand->getMedia('brand_logo')->first()) {
            $logoUrl = $brand->getMedia('brand_logo')->first()->getUrl();
        }
        return response()->json([
            'id' => $brand->id,
            'name' => $brand->name,
            'details' => $brand->details,
            'website' => $brand->website,
            'logo_url' => $logoUrl,
        ]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'details' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'details' => $request->details,
            'website' => $request->website,
        ]);

        // Handle logo upload - replace existing
        if ($request->hasFile('logo')) {
            $brand->clearMediaCollection('brand_logo');
            $brand->addMediaFromRequest('logo')->toMediaCollection('brand_logo');
        }

        return redirect()->back()->with('success', 'Brand updated successfully');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->back()->with('success', 'Brand deleted successfully');
    }
}
