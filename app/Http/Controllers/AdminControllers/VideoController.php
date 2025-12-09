<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Playlist;
use Illuminate\Http\Request;

class VideoController extends Controller {
    /**
     * Display a listing of videos
     */
    public function index(Request $request){
        $query = Video::with('playlist');
        // Filter by playlist
        if ($request->filled('playlist_id')) {
            $query->where('playlist_id', $request->playlist_id);
        }
        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('details', 'like', '%' . $request->search . '%');
            });
        }
        $videos = $query->orderBy('created_at', 'desc')->paginate(15);
        $playlists = Playlist::orderBy('name')->get();
        return view('admin.pages.videos.index', compact('videos', 'playlists'));
    }

    /**
     * Show the form for creating a new video
     */
    public function create(){
        $playlists = Playlist::orderBy('name')->get();
        return view('admin.pages.videos.create', compact('playlists'));
    }

    /**
     * Store a newly created video
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'playlist_id' => 'required|exists:playlists,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:videos,slug',
            'details' => 'nullable|string',
            'link' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $video = Video::create([
            'playlist_id' => $request->playlist_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'details' => $request->details,
            'link' => $request->link,
        ]);
        return redirect()->route('admin.videos.show', $video->id)->with('success', 'Video created successfully');
    }

    /**
     * Display the specified video
     */
    public function show($id){
        $video = Video::with('playlist')->findOrFail($id);
        return view('admin.pages.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified video
     */
    public function edit($id){
        $video = Video::findOrFail($id);
        $playlists = Playlist::orderBy('name')->get();
        return view('admin.pages.videos.edit', compact('video', 'playlists'));
    }

    /**
     * Update the specified video
     */
    public function update(Request $request, $id){
        $video = Video::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'playlist_id' => 'required|exists:playlists,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:videos,slug,' . $id,
            'details' => 'nullable|string',
            'link' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $video->update([
            'playlist_id' => $request->playlist_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'details' => $request->details,
            'link' => $request->link,
        ]);
        return redirect()->route('admin.videos.show', $video->id)->with('success', 'Video updated successfully');
    }

    /**
     * Remove the specified video
     */
    public function destroy($id){
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully');
    }
}
