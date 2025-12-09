<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;

class TipsController extends Controller {

    public function tipsPage(Request $request){
        $query = Video::with('playlist');
        $videos = $query->orderBy('created_at', 'desc')->paginate(15);
        $playlists = Playlist::orderBy('name')->get();
        return view('website.pages.tips.index', compact('videos', 'playlists'));
    }

    public function videosByPlaylist($slug){
        $playlist = Playlist::where('slug', $slug)->firstOrFail();
        $playlists = Playlist::orderBy('name')->get();
        $videos = Video::with('playlist')->where('playlist_id', $playlist->id)->orderBy('created_at', 'desc')->paginate(15);
        return view('website.pages.tips.index', compact('videos', 'playlist', 'playlists'));
    }

    public function singleVideo($slug){
        $video = Video::where('slug', $slug)->with('playlist')->firstOrFail();
        $relatedVideos = Video::where('playlist_id', $video->playlist_id)
            ->where('id', '!=', $video->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $allPlaylists = Playlist::orderBy('name')->get();
        return view('website.pages.singleVideo.index', compact('video', 'relatedVideos', 'allPlaylists'));
    }

}
