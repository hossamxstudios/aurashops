    <!-- mobile menu -->
    <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
        <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
        <div class="mb-canvas-content">
            <div class="mb-body">
                <div class="mb-content-top">
                    <form class="form-search">
                        <fieldset class="text">
                            <input type="text" placeholder="What are you looking for?" class="" name="text" tabindex="0"
                                value="" aria-required="true" required="">
                        </fieldset>
                        <button class="" type="submit">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                                    stroke="#181818" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20.9984 20.9999L16.6484 16.6499" stroke="#181818" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </form>
                    <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                         <li class="nav-mb-item  @if(Route::is('home')) active @endif">
                            <a href="{{ route('home') }}" class="collapsed mb-menu-link">
                                 <span>Home</span>
                            </a>
                        </li>
                        <li class="nav-mb-item @if(Route::is('about')) active @endif">
                            <a href="{{ route('about') }}" class="collapsed mb-menu-link">
                                <span>About Us</span>
                            </a>
                        </li>
                        <li class="nav-mb-item">
                            <a href="#dropdown-menu-shop" class="collapsed mb-menu-link" data-bs-toggle="collapse"
                                aria-expanded="false" aria-controls="dropdown-menu-shop">
                                <span>Shop</span>
                                <span class="btn-open-sub"></span>
                            </a>
                            <div id="dropdown-menu-shop" class="collapse">
                                <ul class="sub-nav-menu">
                                    <li>
                                        <a href="#sub-gender" class="sub-nav-link collapsed" data-bs-toggle="collapse"
                                            aria-expanded="false" aria-controls="sub-gender">
                                            <span>Shop by Gender</span>
                                            <span class="btn-open-sub"></span>
                                        </a>
                                        <div id="sub-gender" class="collapse">
                                            <ul class="sub-nav-menu sub-menu-level-2">
                                                @foreach($navGenders as $gender)
                                                    <li>
                                                        <a href="{{ route('shop.gender', $gender->slug) }}" class="sub-nav-link">
                                                            {{ $gender->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#sub-brand" class="sub-nav-link collapsed" data-bs-toggle="collapse"
                                            aria-expanded="false" aria-controls="sub-brand">
                                            <span>Shop by Brand</span>
                                            <span class="btn-open-sub"></span>
                                        </a>
                                        <div id="sub-brand" class="collapse">
                                            <ul class="sub-nav-menu sub-menu-level-2">
                                                @foreach($navBrands->take(10) as $brand)
                                                    <li>
                                                        <a href="{{ route('shop.brand', $brand->slug) }}" class="sub-nav-link">
                                                            {{ $brand->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#sub-category" class="sub-nav-link collapsed" data-bs-toggle="collapse"
                                            aria-expanded="false" aria-controls="sub-category">
                                            <span>Shop by Category</span>
                                            <span class="btn-open-sub"></span>
                                        </a>
                                        <div id="sub-category" class="collapse">
                                            <ul class="sub-nav-menu sub-menu-level-2">
                                                @foreach($navCategories as $category)
                                                    @if($category->children->isNotEmpty())
                                                        <li>
                                                            <a href="#sub-cat-{{ $category->id }}" class="sub-nav-link collapsed" data-bs-toggle="collapse"
                                                                aria-expanded="false" aria-controls="sub-cat-{{ $category->id }}">
                                                                <span>{{ $category->name }}</span>
                                                                <span class="btn-open-sub"></span>
                                                            </a>
                                                            <div id="sub-cat-{{ $category->id }}" class="collapse">
                                                                <ul class="sub-nav-menu sub-menu-level-3">
                                                                    @foreach($category->children as $subcategory)
                                                                        <li>
                                                                            <a href="{{ route('shop.category', $subcategory->slug) }}" class="sub-nav-link">
                                                                                {{ $subcategory->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ route('shop.category', $category->slug) }}" class="sub-nav-link">
                                                                {{ $category->name }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-mb-item @if(Route::is('tips')) active @endif">
                            <a href="#dropdown-menu-one" class="collapsed mb-menu-link">
                                <span>Beauty Advice</span>
                            </a>
                        </li>
                        <li class="nav-mb-item position-relative @if(Route::is('tips')) active @endif">
                            <a href="{{ route('tips') }}" class="collapsed mb-menu-link">
                                <span>Tips & Tricks</span>
                            </a>
                        </li>
                        <li class="nav-mb-item position-relative @if(Route::is('blogs')) active @endif">
                            <a href="{{ route('blogs') }}" class="collapsed mb-menu-link">
                                <span>Blog</span>
                            </a>
                        </li>
                        <li class="nav-mb-item position-relative @if(Route::is('contact')) active @endif">
                               <a href="{{ route('contact') }}" class="collapsed mb-menu-link">
                                <span>Contact Us</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="mb-other-content">
                    <div class="group-icon">
                        <a href="{{ route('wishlist.index') }}" class="site-nav-icon">
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.8401 4.60987C20.3294 4.09888 19.7229 3.69352 19.0555 3.41696C18.388 3.14039 17.6726 2.99805 16.9501 2.99805C16.2276 2.99805 15.5122 3.14039 14.8448 3.41696C14.1773 3.69352 13.5709 4.09888 13.0601 4.60987L12.0001 5.66987L10.9401 4.60987C9.90843 3.57818 8.50915 2.99858 7.05012 2.99858C5.59109 2.99858 4.19181 3.57818 3.16012 4.60987C2.12843 5.64156 1.54883 7.04084 1.54883 8.49987C1.54883 9.95891 2.12843 11.3582 3.16012 12.3899L4.22012 13.4499L12.0001 21.2299L19.7801 13.4499L20.8401 12.3899C21.3511 11.8791 21.7565 11.2727 22.033 10.6052C22.3096 9.93777 22.4519 9.22236 22.4519 8.49987C22.4519 7.77738 22.3096 7.06198 22.033 6.39452C21.7565 5.72706 21.3511 5.12063 20.8401 4.60987V4.60987Z"
                                    stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Wishlist
                        </a>

                        @if(auth()->guard('client')->check())
                        <form action=" {{ route('client.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="site-nav-icon">
                                <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                        stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                        stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Logout
                            </button>
                        </form>
                        @else
                        <a href="{{ route('client.login') }}" class="site-nav-icon">
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                    stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                    stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Login
                        </a>
                        @endif

                    </div>
                    <div class="mb-notice">
                        <a href="{{ route('contact') }}" class="text-need">Need Help?</a>
                    </div>
                    <div class="mb-contact">
                        <p class="text-caption-1">{{ $settings['address'] ?? ' ' }}</p>
                        <a href="{{ route('contact') }}" class="tf-btn-default text-btn-uppercase">GET DIRECTION<i
                                class="icon-arrowUpRight"></i></a>
                    </div>
                    <ul class="mb-info">
                        <li>
                            <i class="icon icon-mail"></i>
                            <p>{{ $settings['email'] ?? 'No Email' }}</p>
                        </li>
                        <li>
                            <i class="icon icon-phone"></i>
                            <p>{{ $settings['phone'] ?? 'No Phone' }}</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-bottom">
                <div class="bottom-bar-language w-100" style="grid-template-columns: auto!important;">
                    <div class="tf-languages">
                        <select class="image-select center style-default type-languages">
                            <option>English</option>
                            <option>Arabic</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /mobile menu -->
