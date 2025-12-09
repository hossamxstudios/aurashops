<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - Home</title>
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
        @include('website.pages.home.revslider')
        @include('website.pages.home.genders')
        @include('website.pages.home.categories')
        @include('website.pages.home.topPicks')

        @include('website.pages.home.beautyConsultation')
        @include('website.main.footer')
    </div>

    {{-- @include('website.pages.home.modals') --}}
    @foreach($topPicksProducts as $index => $product)
        @include('website.pages.home.quickViewModal')
        @if($product->isBundle())
            @include('website.pages.home.bundleSelectionModal')
        @endif
    @endforeach
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')
</body>
</html>
