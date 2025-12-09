<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - {{ $video->title }}</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="{{ $video->details }}">
    <meta name="keywords" content="beauty tips, makeup tutorials, skincare tricks">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')
        @include('website.pages.singleVideo.header')
        <section class="flat-spacing">
            <div class="container">
                <div class="row">
                    @include('website.pages.singleVideo.content')
                    @include('website.pages.singleVideo.sidebar')
                </div>
            </div>
        </section>
        @include('website.pages.singleVideo.relatedVideos')
        @include('website.main.footer')
    </div>
    {{-- @include('website.pages.home.modals') --}}
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuSiPhoDaOJ7aqtJVtQhYhLzwwJ7rQlmA"></script>
    <script type="text/javascript" src="{{ asset('website/js/map-contact.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/marker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/infobox.min.js') }}"></script>
</body>
</html>
