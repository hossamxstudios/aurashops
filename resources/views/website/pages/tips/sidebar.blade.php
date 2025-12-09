<div class="col-lg-4">
    <div class="sidebar maxw-360">
        <div class="sidebar-item sidebar-categories">
            <h5 class="sidebar-heading">Playlists</h5>
            <ul>
                @foreach ($playlists as $playlist)
                <li>
                    <a class="text-button link" href="{{ route('playlist.videos', $playlist->slug) }}">{{ $playlist->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @if (isset($playlist))
            <div class="sidebar-item sidebar-categories">
                <h5 class="sidebar-heading">Tags</h5>
                <ul>
                    @foreach ($playlists as $pl)
                    <li>
                        <a class="text-button link" href="{{ route('playlist.videos', $pl->slug) }}">{{ $pl->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
