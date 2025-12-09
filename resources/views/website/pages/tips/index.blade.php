<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Tips & Tricks</title>
    <meta name="title" content="https://aurashops.co/">
    <meta name="description" content="Beauty tips, tutorials and makeup tricks">
    <meta name="keywords" content="beauty tips, makeup tutorials, skincare tricks">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper">
        @include('website.main.navbar')
        @include('website.pages.tips.header')
        <div class="main-content-page">
            <div class="container">
                <div class="row">
                    @include('website.pages.tips.all')
                    @include('website.pages.tips.sidebar')
                </div>
            </div>
        </div>
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
