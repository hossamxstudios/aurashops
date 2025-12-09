        <div class="pt-5 page-title" style="background-image: url({{ asset('website/images/section/page-title.jpg') }});">
            <div class="pt-5 container-full">
                <div class="pt-5 row">
                    <div class="pt-5 col-12">
                        <h3 class="text-center heading">{{ $category->name }}</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li>
                                <a class="link" href="{{ route('home') }}">Homepage</a>
                            </li>
                            <li>
                                <i class="icon-arrRight"></i>
                            </li>
                            <li>
                                {{ $category->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
