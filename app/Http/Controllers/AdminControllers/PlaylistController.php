<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller {
    /**
     * Display a listing of playlists
     */
    public function index(){
        $playlists = Playlist::withCount('videos')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.pages.playlists.index', compact('playlists'));
    }

    /**
     * Store a newly created playlist
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:playlists,slug',
            'details' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Playlist::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'details' => $request->details,
        ]);
        return redirect()->route('admin.playlists.index')->with('success', 'Playlist created successfully');
    }

    /**
     * Get playlist for editing (AJAX)
     */
    public function edit($id){
        $playlist = Playlist::findOrFail($id);
        return response()->json($playlist);
    }

    /**
     * Update the specified playlist
     */
    public function update(Request $request, $id){
        $playlist = Playlist::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:playlists,slug,' . $id,
            'details' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $playlist->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'details' => $request->details,
        ]);
        return redirect()->route('admin.playlists.index')->with('success', 'Playlist updated successfully');
    }

    /**
     * Remove the specified playlist
     */
    public function destroy($id){
        $playlist = Playlist::findOrFail($id);
        if ($playlist->videos()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete playlist with associated videos');
        }
        $playlist->delete();
        return redirect()->route('admin.playlists.index')->with('success', 'Playlist deleted successfully');
    }
}
