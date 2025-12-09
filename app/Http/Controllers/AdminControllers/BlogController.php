<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller {
    /**
     * Display a listing of blogs
     */
    public function index(Request $request){
        $query = Blog::with('topic');
        // Filter by topic
        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }
        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        $blogs = $query->orderBy('created_at', 'desc')->paginate(15);
        $topics = Topic::orderBy('name')->get();
        return view('admin.pages.blogs.index', compact('blogs', 'topics'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create(){
        $topics = Topic::orderBy('name')->get();
        return view('admin.pages.blogs.create', compact('topics'));
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_desc' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $blog = Blog::create([
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'slug' => $request->slug,
            'content' => $request->content,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'meta_title' => $request->meta_title,
            'meta_desc' => $request->meta_desc,
            'meta_keywords' => $request->meta_keywords,
        ]);
        // Handle image upload
        if ($request->hasFile('image')) {
            $blog->addMediaFromRequest('image')->toMediaCollection('blog-images');
        }
        return redirect()->route('admin.blogs.show', $blog->id)->with('success', 'Blog created successfully');
    }

    /**
     * Display the specified blog
     */
    public function show($id){
        $blog = Blog::with('topic')->findOrFail($id);
        return view('admin.pages.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit($id){
        $blog = Blog::findOrFail($id);
        $topics = Topic::orderBy('name')->get();
        return view('admin.pages.blogs.edit', compact('blog', 'topics'));
    }

    /**
     * Update the specified blog
     */
    public function update(Request $request, $id){
        $blog = Blog::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $id,
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_desc' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $blog->update([
            'topic_id' => $request->topic_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'slug' => $request->slug,
            'content' => $request->content,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'meta_title' => $request->meta_title,
            'meta_desc' => $request->meta_desc,
            'meta_keywords' => $request->meta_keywords,
        ]);
        // Handle image upload
        if ($request->hasFile('image')) {
            $blog->clearMediaCollection('blog-images');
            $blog->addMediaFromRequest('image')->toMediaCollection('blog-images');
        }
        return redirect()->route('admin.blogs.show', $blog->id)->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified blog
     */
    public function destroy($id){
        $blog = Blog::findOrFail($id);
        $blog->clearMediaCollection('blog-images');
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully');
    }
}
