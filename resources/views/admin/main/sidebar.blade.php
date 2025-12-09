<div class="sidenav-menu igi">
    <div class="scrollbar" data-simplebar>
        <div class="border border-dashed sidenav-user text-nowrap rounded-3">
            <a href="#!" class="sidenav-user-name d-flex align-items-center">
                <img src="{{ asset('admin/assets/images/users/user-2.jpg') }}" width="36" class="rounded-circle me-2 d-flex"
                    alt="user-image">
                <span>
                    <h5 class="my-0 fw-semibold">{{ auth()->user()->name ?? 'Admin User' }}</h5>
                    <h6 class="my-0 text-muted">{{ auth()->user()->role ?? 'Administrator' }}</h6>
                </span>
            </a>
        </div>
        <ul class="side-nav">
            <!-- Dashboard -->
            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('admin.pos.index') }}" class="side-nav-link {{ request()->routeIs('admin.pos.index') ? 'active' : '' }}">
                    <span class="menu-icon"><i data-lucide="shopping-cart"></i></span>
                    <span class="menu-text">POS</span>
                </a>
            </li>
            <!-- Sales & Orders -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSales" aria-expanded="false" aria-controls="sidebarSales"
                    class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="calculator"></i></span>
                    <span class="menu-text">Sales & Orders</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSales">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.orders.index') }}" class="side-nav-link">
                                <span class="menu-text">Orders</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.return-orders.index') }}" class="side-nav-link">
                                <span class="menu-text">Return Orders</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Products -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarProducts" aria-expanded="false"
                    aria-controls="sidebarProducts" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="package"></i></span>
                    <span class="menu-text">Products</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarProducts">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.products.index') }}" class="side-nav-link">
                                <span class="menu-text">All Products</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="side-nav-link">
                                <span class="menu-text">Categories</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.brands.index') }}" class="side-nav-link">
                                <span class="menu-text">Brands</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.genders.index') }}" class="side-nav-link">
                                <span class="menu-text">Genders</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.attributes.index') }}" class="side-nav-link">
                                <span class="menu-text">Attributes</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.tags.index') }}" class="side-nav-link">
                                <span class="menu-text">Tags</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Inventory -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarInventory" aria-expanded="false"
                    aria-controls="sidebarInventory" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="box"></i></span>
                    <span class="menu-text">Inventory</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarInventory">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.stocks.index') }}" class="side-nav-link">
                                <span class="menu-text">Stocks</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.warehouses.index') }}" class="side-nav-link">
                                <span class="menu-text">Warehouses</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.suppliers.index') }}" class="side-nav-link">
                                <span class="menu-text">Suppliers</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.supplies.index') }}" class="side-nav-link">
                                <span class="menu-text">Supplies</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Shipping & Delivery -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarShipping" aria-expanded="false"
                    aria-controls="sidebarShipping" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="truck"></i></span>
                    <span class="menu-text">Shipping</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarShipping">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.shipments.index') }}" class="side-nav-link">
                                <span class="menu-text">Shipments</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.shippers.index') }}" class="side-nav-link">
                                <span class="menu-text">Shippers</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.shipping-rates.index') }}" class="side-nav-link">
                                <span class="menu-text">Shipping Rates</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.locations.index') }}" class="side-nav-link">
                                <span class="menu-text">Locations</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.pickup-locations.index') }}" class="side-nav-link">
                                <span class="menu-text">Pickup Locations</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Customers -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCustomers" aria-expanded="false"
                    aria-controls="sidebarCustomers" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-text">Customers</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCustomers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.clients.index') }}" class="side-nav-link">
                                <span class="menu-text">All Clients</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.skin-tones.index') }}" class="side-nav-link">
                                <span class="menu-text">Skin Tones</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.skin-types.index') }}" class="side-nav-link">
                                <span class="menu-text">Skin Types</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.concerns.index') }}" class="side-nav-link">
                                <span class="menu-text">Concerns</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Marketing -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMarketing" aria-expanded="false"
                    aria-controls="sidebarMarketing" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="megaphone"></i></span>
                    <span class="menu-text">Marketing</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMarketing">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.coupons.index') }}" class="side-nav-link">
                                <span class="menu-text">Coupons</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.newsletters.index') }}" class="side-nav-link">
                                <span class="menu-text">Newsletter</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.contact-forms.index') }}" class="side-nav-link">
                                <span class="menu-text">Contact Forms</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Content -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarContent" aria-expanded="false"
                    aria-controls="sidebarContent" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="file-text"></i></span>
                    <span class="menu-text">Content</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarContent">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.blogs.index') }}" class="side-nav-link">
                                <span class="menu-text">Blogs</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.topics.index') }}" class="side-nav-link">
                                <span class="menu-text">Topics</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.videos.index') }}" class="side-nav-link">
                                <span class="menu-text">Videos</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.playlists.index') }}" class="side-nav-link">
                                <span class="menu-text">Playlists</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Configuration -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarConfiguration" aria-expanded="false"
                    aria-controls="sidebarConfiguration" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="settings"></i></span>
                    <span class="menu-text">Configuration</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarConfiguration">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.order-statuses.index') }}" class="side-nav-link">
                                <span class="menu-text">Order Statuses</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.payment-methods.index') }}" class="side-nav-link">
                                <span class="menu-text">Payment Methods</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.bank-accounts.index') }}" class="side-nav-link">
                                <span class="menu-text">Bank Accounts</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.return-reasons.index') }}" class="side-nav-link">
                                <span class="menu-text">Return Reasons</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="side-nav-link">
                                <span class="menu-text">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="menu-collapse-box d-none d-xl-block">
        <button class="button-collapse-toggle">
            <i data-lucide="square-chevron-left" class="flex-shrink-0 align-middle"></i> <span>Collapse Menu</span>
        </button>
    </div>
</div>


<style>
    .igi::after {
        width: 18px;
        height: 18px;
        top: 1px;
        right: -18px;
        position: absolute;
        border-top-left-radius: 50%;
        content: "";
        box-shadow: var(--ins-sidenav-bg) -9px -1px 0px 0px;
        pointer-events: none;
    }
</style>
