<!-- breadcrumb -->
<div class="pt-5 tf-breadcrumb">
    <div class="container pt-5">
        <div class="pt-3 tf-breadcrumb-wrap">
            <div class="tf-breadcrumb-list">
                <a href="{{ route('home') }}" class="text text-caption-1">Homepage</a>
                <i class="icon icon-arrRight"></i>
                {{-- <a href="{{ route('shop.brands', $product->brand->slug) }}" class="text text-caption-1">{{ $product->brand->name }}</a>
                <i class="icon icon-arrRight"></i>
                <a href="{{ route('shop.genders', $product->gender->slug) }}" class="text text-caption-1">{{ $product->gender->name }}</a>
                <i class="icon icon-arrRight"></i>
                <a href="{{ route('shop.categories', $product->category->slug) }}" class="text text-caption-1">{{ $product->category->name }}</a>
                <i class="icon icon-arrRight"></i> --}}
                <span class="text text-caption-1">{{ $product->name }}</span>
            </div>
            {{-- <div class="tf-breadcrumb-prev-next">
                <a href="{{ route('product.show', $product->slug) }}" class="tf-breadcrumb-prev">
                    <i class="icon icon-arrLeft"></i>
                </a>
                <a href="{{ route('product.show', $product->slug) }}" class="tf-breadcrumb-back">
                    <i class="icon icon-squares-four"></i>
                </a>
                <a href="{{ route('product.show', $product->slug) }}" class="tf-breadcrumb-next">
                    <i class="icon icon-arrRight"></i>
                </a>
            </div> --}}
        </div>
    </div>
</div>
<!-- /breadcrumb -->
