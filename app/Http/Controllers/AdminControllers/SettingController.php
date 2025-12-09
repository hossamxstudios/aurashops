<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller {
    /**
     * Display a listing of settings
     */
    public function index(Request $request){
        $query = Setting::query();
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('key', 'like', '%' . $request->search . '%')
                  ->orWhere('value', 'like', '%' . $request->search . '%');
            });
        }
        $settings = $query->orderBy('category')->orderBy('key')->paginate(20);
        $categories = Setting::select('category')->distinct()->orderBy('category')->pluck('category');
        return view('admin.pages.settings.index', compact('settings', 'categories'));
    }

    /**
     * Store a newly created setting
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'nullable|string',
            'details' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Setting::create([
            'category' => $request->category,
            'type' => $request->type,
            'key' => $request->key,
            'value' => $request->value,
            'details' => $request->details,
            'is_public' => $request->has('is_public') ? 1 : 0,
        ]);
        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully');
    }

    /**
     * Get setting for editing (AJAX)
     */
    public function edit($id){
        $setting = Setting::findOrFail($id);
        return response()->json($setting);
    }

    /**
     * Update the specified setting
     */
    public function update(Request $request, $id){
        $setting = Setting::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:settings,key,' . $id,
            'value' => 'nullable|string',
            'details' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $setting->update([
            'category' => $request->category,
            'type' => $request->type,
            'key' => $request->key,
            'value' => $request->value,
            'details' => $request->details,
            'is_public' => $request->has('is_public') ? 1 : 0,
        ]);
        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully');
    }

    /**
     * Remove the specified setting
     */
    public function destroy($id){
        $setting = Setting::findOrFail($id);
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Setting deleted successfully');
    }
}
