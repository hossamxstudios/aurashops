<div class="col-lg-4">
    <div class="sidebar maxw-360">
        <div class="sidebar-item sidebar-categories">
            <h5 class="sidebar-heading">Topics</h5>
            <ul>
                @foreach ($topics as $topic)
                <li>
                    <a class="text-button link" href="{{ route('topic.blogs', $topic->slug) }}">{{ $topic->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @if (isset($topic))
            <div class="sidebar-item sidebar-categories">
                <h5 class="sidebar-heading">Tags</h5>
                <ul>
                    @foreach ($topics as $topic)
                    <li>
                        <a class="text-button link" href="{{ route('topic.blogs', $topic->slug) }}">{{ $topic->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
