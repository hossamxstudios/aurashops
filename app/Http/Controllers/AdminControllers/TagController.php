<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name', 'asc')->get();
        return view('admin.pages.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Tag::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully');
    }

    public function quickCreate(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first('name')
            ], 422);
        }

        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'tag' => [
                'id' => $tag->id,
                'name' => $tag->name,
            ],
            'message' => 'Tag created successfully'
        ]);
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $tags = Tag::orderBy('name', 'asc')->get();

        return view('admin.pages.tags.index', compact('tags', 'tag'));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully');
    }
}
