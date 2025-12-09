<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of topics
     */
    public function index()
    {
        $topics = Topic::withCount('blogs')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.topics.index', compact('topics'));
    }

    /**
     * Store a newly created topic
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:topics,slug',
            'details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Topic::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'details' => $request->details,
        ]);

        return redirect()->route('admin.topics.index')->with('success', 'Topic created successfully');
    }

    /**
     * Get topic for editing (AJAX)
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        return response()->json($topic);
    }

    /**
     * Update the specified topic
     */
    public function update(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:topics,slug,' . $id,
            'details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $topic->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'details' => $request->details,
        ]);

        return redirect()->route('admin.topics.index')->with('success', 'Topic updated successfully');
    }

    /**
     * Remove the specified topic
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        
        if ($topic->blogs()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete topic with associated blogs');
        }
        
        $topic->delete();

        return redirect()->route('admin.topics.index')->with('success', 'Topic deleted successfully');
    }
}
