<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    @if(isset($topic))
        <title>Aura - {{ $topic->name }}</title>
    @else
        <title>Aura - Blogs</title>
    @endif
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="A cosmetics website">
    <meta name="keywords" content="cosmetics, skin care, hair care, body care, beauty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')
        @include('website.pages.blogs.header')
        <div class="main-content-page">
            <div class="container">
                <div class="row">
                    @include('website.pages.blogs.all')
                    @include('website.pages.blogs.sidebar')
                </div>
            </div>
        </div>
        @include('website.main.footer')
    </div>
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuSiPhoDaOJ7aqtJVtQhYhLzwwJ7rQlmA"></script>
    <script type="text/javascript" src="{{ asset('website/js/map-contact.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/marker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/infobox.min.js') }}"></script>
</body>
</html>
