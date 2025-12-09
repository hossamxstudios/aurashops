<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>Aura - All Products</title>
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
        @include('website.pages.shopAll.header')
        @include('website.pages.shopAll.categories')
        @include('website.pages.shopAll.products')
        @include('website.main.footer')
    </div>
    @foreach($products as $index => $product)
        @include('website.pages.home.quickViewModal')
        @if($product->isBundle())
            @include('website.pages.home.bundleSelectionModal')
        @endif
    @endforeach
    {{-- @include('website.pages.home.modals') --}}
    @include('website.pages.home.cartModal')
    @include('website.main.scripts')
</body>
</html>
