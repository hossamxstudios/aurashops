<!DOCTYPE html>
<html xml:lang="en-US" lang="en-US">
<head>
    <title>{{ $product->name }} - Aura Shops</title>
    <!-- Basic Meta Tags -->
    <meta name="title" content="{{ $product->name }} - Aura Cosmetics">
    <meta name="description" content="{{ $product->details ?? 'Shop ' . $product->name . ' at Aura Cosmetics. High-quality beauty and cosmetics products.' }}">
    <meta name="keywords" content="{{ $product->name }}, cosmetics, beauty, {{ $product->category->name ?? 'makeup' }}, aurashops">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <!-- Open Graph Meta Tags (Facebook) -->
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ $product->details ?? 'Shop ' . $product->name . ' at Aura Cosmetics' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Aura Cosmetics">
    <meta property="og:image" content="{{ $product->getFirstMediaUrl('product_thumbnail') }}">
    <meta property="og:image:secure_url" content="{{ $product->getFirstMediaUrl('product_thumbnail') ?? null }}">
    <meta property="og:image:width" content="{{ $product->getFirstMedia('product_thumbnail')?->width ?? null }}">
    <meta property="og:image:height" content="{{ $product->getFirstMedia('product_thumbnail')?->height ?? null }}">
    <meta property="og:image:alt" content="{{ $product->name }}">
    <!-- Product Specific Open Graph Tags -->
    <meta property="product:price:amount" content="{{ $product->variants->first()->price ?? $product->price ?? '0' }}">
    <meta property="product:price:currency" content="EGP">
    <meta property="product:availability" content="{{ $product->stock > 0 ? 'in stock' : 'out of stock' }}">
    <meta property="product:condition" content="new">
    <meta property="product:brand" content="{{ $product->brand->name ?? 'Aura Cosmetics' }}">
    <meta property="product:category" content="{{ $product->category->name ?? 'Cosmetics' }}">
    @if($product->variants->isNotEmpty())
        @foreach($product->variants as $variant)
            <meta property="product:retailer_item_id" content="{{ $variant->sku ?? $product->id }}">
        @endforeach
    @endif
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{{ $product->description ?? 'Shop ' . $product->name . ' at Aura Cosmetics' }}">
    <meta name="twitter:image" content="{{ $product->getFirstMediaUrl('product_thumbnail') }}">
    <meta name="twitter:site" content="@aurashops">
    <!-- Additional SEO Meta Tags -->
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:updated_time" content="{{ $product->updated_at->toIso8601String() }}">
    @include('website.main.meta')
</head>
<body class="preload-wrapper">
    <div id="wrapper" class="bg-surface">
        @include('website.main.navbar')
        @include('website.pages.product.breadcrumb')
        @include('website.pages.product.product')
        @include('website.pages.product.productTabs')
        @include('website.pages.product.relatedProducts')
        @include('website.main.footer')
    </div>

    @include('website.pages.home.cartModal')

    @if($product->isBundle())
        @include('website.pages.home.bundleSelectionModal', ['product' => $product])
    @endif

    @include('website.main.scripts')
</body>
</html>
