<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller {

    public function blogPage(Request $request){
        $query = Blog::with('topic');
        $blogs = $query->orderBy('created_at', 'desc')->paginate(15);
        $topics = Topic::orderBy('name')->get();
        return view('website.pages.blogs.index', compact('blogs', 'topics'));
    }

    public function blogByTopic($slug){
        $topic = Topic::where('slug', $slug)->first();
        $topics = Topic::orderBy('name')->get();
        $blogs = Blog::with('topic')->where('topic_id', $topic->id)->orderBy('created_at', 'desc')->paginate(15);
        return view('website.pages.blogs.index', compact('blogs', 'topic', 'topics'));
    }

    public function singleBlog($slug){
        $blog = Blog::where('slug', $slug)->first();
        $relatedBlogs = Blog::with('topic')->where('topic_id', $blog->topic_id)->orderBy('created_at', 'desc')->take(5)->get();
        $topics = Topic::orderBy('name')->get();
        return view('website.pages.singleBlog.index', compact('blog', 'relatedBlogs', 'topics'));
    }

}
