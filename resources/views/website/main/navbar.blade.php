
        <header id="header" class="header-default header-absolute header-style-6">
            <div class="container-full2">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 d-xl-none">
                        <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                            <i class="icon icon-categories"></i>
                        </a>
                    </div>
                    <div class="col-xl-9 col-md-4 col-6">
                        <div class="header-left justify-content-xl-start justify-content-center">
                            <a href="/" class="logo-header">
                                <img src="{{ asset('website/logo.png') }}" alt="logo" class="logo">
                            </a>
                            {{-- <div class="tf-list-categories style-2 d-none d-xl-block">
                                <a href="#" class="categories-title text-title">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_19494_2169)">
                                            <path
                                                d="M9.75 3.75H5.25C4.83579 3.75 4.5 4.08579 4.5 4.5V19.5C4.5 19.9142 4.83579 20.25 5.25 20.25H9.75C10.1642 20.25 10.5 19.9142 10.5 19.5V4.5C10.5 4.08579 10.1642 3.75 9.75 3.75Z"
                                                stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M20.4065 19.2907L16.018 20.2282C15.9213 20.2488 15.8215 20.25 15.7242 20.2318C15.627 20.2137 15.5344 20.1765 15.4516 20.1224C15.3688 20.0683 15.2976 19.9983 15.2419 19.9166C15.1863 19.8348 15.1474 19.7428 15.1274 19.646L12.0168 4.85599C11.9749 4.66061 12.0121 4.45662 12.1201 4.28853C12.2281 4.12044 12.3982 4.00191 12.5933 3.9588L16.9818 3.0213C17.0785 3.00072 17.1784 2.99948 17.2756 3.01764C17.3728 3.03579 17.4654 3.073 17.5482 3.12711C17.631 3.18122 17.7022 3.25116 17.7579 3.33292C17.8135 3.41468 17.8524 3.50663 17.8724 3.60349L20.983 18.3935C21.0249 18.5889 20.9877 18.7929 20.8797 18.9609C20.7717 19.129 20.6016 19.2476 20.4065 19.2907Z"
                                                stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4.5 6.75H10.5" stroke="black" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M4.5 17.25H10.5" stroke="black" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M12.4844 7.07648L18.3391 5.81836" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M13.1094 10.0355L18.965 8.77734" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14.6641 17.432L20.5187 16.1738" stroke="black"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_19494_2169">
                                                <rect width="24" height="24" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="d-none d-xxl-block">Browse by Category</span>
                                    <span class="icon icon-arrow-down"></span>
                                </a>
                                <div class="list-categories-inner">
                                    <ul class="text-title">
                                        <li class="sub-categories2">
                                            <a href="#" class="categories-item"><span class="inner-left">Book</span><i
                                                    class="icon icon-arrRight"></i></a>
                                            <ul class="list-categories-inner">
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Book</span></a></li>
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Book</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub-categories2">
                                            <a href="#" class="categories-item"><span
                                                    class="inner-left">Fiction</span><i
                                                    class="icon icon-arrRight"></i></a>
                                            <ul class="list-categories-inner">
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Fiction</span></a></li>
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Fiction</span></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#" class="categories-item"><span
                                                    class="inner-left">Nonfiction</span></a></li>
                                        <li class="sub-categories2">
                                            <a href="#" class="categories-item"><span class="inner-left">eBooks</span><i
                                                    class="icon icon-arrRight"></i></a>
                                            <ul class="list-categories-inner">
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">eBooks</span></a></li>
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">eBooks</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="sub-categories2">
                                            <a href="#" class="categories-item"><span
                                                    class="inner-left">Audiobooks</span><i
                                                    class="icon icon-arrRight"></i></a>
                                            <ul class="list-categories-inner">
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Audiobooks</span></a></li>
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Audiobooks</span></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#" class="categories-item"><span class="inner-left">Teens &
                                                    YA</span></a></li>
                                        <li><a href="#" class="categories-item"><span class="inner-left">Kids</span></a>
                                        </li>
                                        <li><a href="#" class="categories-item"><span class="inner-left">Toys &
                                                    Games</span></a></li>
                                        <li class="sub-categories2">
                                            <a href="#" class="categories-item"><span class="inner-left">Music &
                                                    Movies</span><i class="icon icon-arrRight"></i></a>
                                            <ul class="list-categories-inner">
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Music & Movies</span></a></li>
                                                <li><a href="#" class="categories-item text-title"><span
                                                            class="inner-left">Music & Movies</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                            <nav class="text-center box-navigation d-none d-xl-block">
                                <ul class="box-nav-ul d-flex align-items-center justify-content-center">
                                    <li class="menu-item active">
                                        <a href="{{ route('home') }}" class="item-link">Home</a>
                                    </li>
                                     <li class="menu-item">
                                        <a href="{{ route('about') }}" class="item-link">About Us</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('shop.all') }}" class="item-link">Shop<i class="icon icon-arrow-down"></i></a>
                                        <div class="sub-menu mega-menu">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <div class="mega-menu-item">
                                                            <div class="menu-heading">Shop by Gender</div>
                                                            <ul class="menu-list">
                                                                @foreach($navGenders as $gender)
                                                                    <li>
                                                                        <a href="{{ route('shop.gender', $gender->slug) }}" class="menu-link-text">
                                                                            {{ $gender->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mega-menu-item">
                                                            <div class="menu-heading">Shop by Brand</div>
                                                            <ul class="menu-list">
                                                                @foreach($navBrands->take(9) as $brand)
                                                                    <li>
                                                                        <a href="{{ route('shop.brand', $brand->slug) }}" class="menu-link-text">
                                                                            {{ $brand->name }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mega-menu-item">
                                                            <div class="menu-heading">Shop by Category</div>
                                                            <ul class="menu-list">
                                                                @foreach($navCategories->take(5) as $category)
                                                                    @if($category->children->isNotEmpty())
                                                                        <li class="menu-item-2">
                                                                            <a href="{{ route('shop.category', $category->slug) }}" class="menu-link-text link">{{ $category->name }}</a>
                                                                            <div class="sub-menu submenu-default">
                                                                                <ul class="menu-list">
                                                                                    @foreach($category->children->take(5) as $subcategory)
                                                                                        <li>
                                                                                            <a href="{{ route('shop.category', $subcategory->slug) }}" class="menu-link-text link">
                                                                                                {{ $subcategory->name }}
                                                                                            </a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <a href="{{ route('shop.category', $category->slug) }}" class="menu-link-text">
                                                                                {{ $category->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-lg-2">
                                                        <div class="mega-menu-item">
                                                            <div class="menu-heading">My Pages</div>
                                                            <ul class="menu-list">
                                                                <li><a href="wish-list.html" class="menu-link-text">Wish
                                                                        List</a></li>
                                                                <li><a href="search-result.html"
                                                                        class="menu-link-text">Search Result</a></li>
                                                                <li><a href="shopping-cart.html"
                                                                        class="menu-link-text">Shopping Cart</a></li>
                                                                <li><a href="login.html"
                                                                        class="menu-link-text">Login/Register</a></li>
                                                                <li><a href="forget-password.html"
                                                                        class="menu-link-text">Forget Password</a></li>
                                                                <li><a href="order-tracking.html"
                                                                        class="menu-link-text">Order Tracking</a></li>
                                                                <li><a href="my-account.html" class="menu-link-text">My
                                                                        Account</a></li>
                                                            </ul>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-lg-4">
                                                        <div class="wrapper-sub-shop">
                                                            <div class="menu-heading">Featured Products</div>
                                                            <div dir="ltr" class="swiper tf-product-header">
                                                                <div class="swiper-wrapper">
                                                                    @foreach($topPicksProducts->take(4) as $product)
                                                                        <div class="swiper-slide">
                                                                            <div class="card-product">
                                                                                <div class="card-product-wrapper">
                                                                                    <a href="{{ route('product.show', $product->slug) }}" class="product-img">
                                                                                        <img class="lazyload img-product"
                                                                                            data-src="{{ $product->getFirstMediaUrl('product_thumbnail') }}"
                                                                                            src="{{ $product->getFirstMediaUrl('product_thumbnail') }}"
                                                                                            alt="{{ $product->name }}">
                                                                                        <img class="lazyload img-hover"
                                                                                            data-src="{{ $product->getMedia('product_images')->skip(1)->first()?->getUrl() ?? $product->getFirstMediaUrl('product_thumbnail') }}"
                                                                                            src="{{ $product->getMedia('product_images')->skip(1)->first()?->getUrl() ?? $product->getFirstMediaUrl('product_thumbnail') }}"
                                                                                            alt="{{ $product->name }}">
                                                                                    </a>
                                                                                    <div class="list-product-btn">
                                                                                        <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                                                            <span class="icon icon-heart"></span>
                                                                                            <span class="tooltip">Wishlist</span>
                                                                                        </a>
                                                                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                                                                                            <span class="icon icon-gitDiff"></span>
                                                                                            <span class="tooltip">Compare</span>
                                                                                        </a>
                                                                                        <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                                                                                            <span class="icon icon-eye"></span>
                                                                                            <span class="tooltip">Quick View</span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="list-btn-main">
                                                                                        <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="card-product-info">
                                                                                    <a href="{{ route('product.show', $product->slug) }}" class="title link">{{ $product->name }}</a>
                                                                                    <span class="price">{{ $product->price ?? '0' }} EGP</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#" class="item-link">Beauty Advice</i></a>
                                    </li>
                                    <li class="menu-item position-relative">
                                        <a href="{{ route('tips') }}" class="item-link">Tips & Tricks</a>
                                    </li>
                                    <li class="menu-item position-relative">
                                        <a href="{{ route('blogs') }}" class="item-link">Blog</a>
                                    </li>
                                    <li class="menu-item position-relative">
                                        <a href="{{ route('contact') }}" class="item-link">Contact Us</a>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-3">
                        <div class="header-right">
                            <form class="form-search d-xl-flex d-none position-relative">
                                <fieldset class="text w-100">
                                    <input type="text" placeholder="Search Products" class="style-line-bottom" name="text" tabindex="0" value="" aria-required="true" required="">
                                </fieldset>
                                <button class="" type="submit">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_19494_2214)">
                                            <path d="M10.5 18C14.6421 18 18 14.6421 18 10.5C18 6.35786 14.6421 3 10.5 3C6.35786 3 3 6.35786 3 10.5C3 14.6421 6.35786 18 10.5 18Z" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.8047 15.8037L21.0012 21.0003" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_19494_2214">
                                                <rect width="24" height="24" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </form>
                            <ul class="nav-icon d-flex justify-content-end align-items-center">
                                <li class="nav-search d-xl-none d-flex"><a href="#search" data-bs-toggle="modal" class="nav-icon-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M21.35 21.0004L17 16.6504" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a></li>
                                <li class="nav-account">
                                    <a href="#" class="nav-icon-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <div class="dropdown-account dropdown-login">
                                        @auth('client')
                                            <div class="sub-top">
                                                <h6 class="mb-2">Hello, {{ Auth::guard('client')->user()->full_name }}</h6>
                                                <ul class="list-unstyled">
                                                    <li><a href="{{ route('profile.edit') }}" class="py-2 d-block">Account</a></li>
                                                    <li><a href="{{ route('cart.page') }}" class="py-2 d-block">Cart</a></li>
                                                    <li><a href="{{ route('wishlist.index') }}" class="py-2 d-block">Wishlist</a></li>
                                                    <li>
                                                        <form action="{{ route('client.logout') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="p-0 btn btn-link text-danger">Logout</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @else
                                            <div class="sub-top">
                                                <a href="{{ route('client.login') }}" class="tf-btn btn-reset">Login</a>
                                                <p class="text-center text-secondary-2">Don't have an account?   <a
                                                        href="{{ route('client.register') }}">Create an account</a></p>
                                            </div>
                                        @endauth
                                        <div class="sub-bot">
                                            <span class="body-text-">Support</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-wishlist"><a href="{{ route('wishlist.index') }}" class="nav-icon-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M20.8401 4.60987C20.3294 4.09888 19.7229 3.69352 19.0555 3.41696C18.388 3.14039 17.6726 2.99805 16.9501 2.99805C16.2276 2.99805 15.5122 3.14039 14.8448 3.41696C14.1773 3.69352 13.5709 4.09888 13.0601 4.60987L12.0001 5.66987L10.9401 4.60987C9.90843 3.57818 8.50915 2.99858 7.05012 2.99858C5.59109 2.99858 4.19181 3.57818 3.16012 4.60987C2.12843 5.64156 1.54883 7.04084 1.54883 8.49987C1.54883 9.95891 2.12843 11.3582 3.16012 12.3899L4.22012 13.4499L12.0001 21.2299L19.7801 13.4499L20.8401 12.3899C21.3511 11.8791 21.7565 11.2727 22.033 10.6052C22.3096 9.93777 22.4519 9.22236 22.4519 8.49987C22.4519 7.77738 22.3096 7.06198 22.033 6.39452C21.7565 5.72706 21.3511 5.12063 20.8401 4.60987V4.60987Z"
                                                stroke="#181818" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                                <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal"
                                        class="nav-icon-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z"
                                                stroke="#181818" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="count-box bg-dark" id="cartCountBadgeMobile">{{ $cart && $cart->items ? $cart->items->sum('qty') : 0 }}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
