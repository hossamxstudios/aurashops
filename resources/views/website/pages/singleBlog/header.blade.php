 <div class="page-title" style="background-image: url({{ asset('website/images/section/page-title.jpg') }});">
    <div class="mt-5 container-full">
        <div class="pt-5 row">
            <div class="col-12">
                <h3 class="text-center heading">{{ $blog->title }}</h3>
                <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                    <li>
                        <a class="link" href="{{ route('home') }}">Homepage</a>
                    </li>
                    <li>
                        <i class="icon-arrRight"></i>
                    </li>
                    <li>
                        <a class="link" href="{{ route('blogs') }}">Blogs</a>
                    </li>
                    <li>
                        <i class="icon-arrRight"></i>
                    </li>
                    @if (isset($blog->topic))
                        <li>
                            {{ $blog->topic?->name }}
                        </li>
                    @else
                        <li>
                            {{ $blog->title }}
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
