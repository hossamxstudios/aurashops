        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="container-fluid topbar-menu">
                <div class="gap-2 d-flex align-items-center justify-content-center">
                    <div class="logo-topbar">
                        <a href="{{ route('admin.dashboard') }}" class="logo-dark">
                            <span class="gap-1 d-flex align-items-center">
                                <img src="{{ asset('admin/assets/images/logo-sm.png') }}" height="30" alt="Logo">
                                <span class="logo-text text-body fw-bold" style="font-size:24px;">Aura</span>
                            </span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="logo-light">
                            <span class="gap-1 d-flex align-items-center">
                                <img src="{{ asset('admin/assets/images/logo-sm-dark.png') }}" height="30" alt="Logo">
                                <span class="logo-text text-body fw-bold" style="font-size:24px;">Aura  </span>
                            </span>
                        </a>
                    </div>
                    <div class="mx-1 d-lg-none d-flex">
                        <a href="{{ route('admin.dashboard') }}" class="logo-dark">
                            <img src="{{ asset('admin/assets/images/logo-sm.png') }}" height="30" alt="Logo">
                        </a>
                    </div>
                    <!-- Sidebar Hover Menu Toggle Button -->
                    <button class="button-collapse-toggle d-xl-none">
                        <i data-lucide="menu" class="align-middle fs-22"></i>
                    </button>
                </div>

                <div class="gap-2 d-flex align-items-center">
                    <!-- Theme Dropdown -->
                    <div class="topbar-item me-2">
                        <div class="dropdown" data-dropdown="custom">
                            <button class="topbar-link fw-semibold" data-bs-toggle="dropdown" data-bs-offset="0,19"
                                type="button" aria-haspopup="false" aria-expanded="false">
                                <img data-trigger-img src="{{ asset('admin/assets/images/themes/shadcn.svg') }}" alt="user-image" class="rounded w-100 me-2" height="18">
                                <span data-trigger-label class="text-nowrap"> Shadcn </span>
                                <span class="dot-blink" aria-label="live status indicator"></span>
                            </button>
                            <div class="p-1 dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <div class="h-100" style="max-height: 250px;" data-simplebar>
                                    <div class="row g-0">
                                        <div class="col-md-6">
                                            <button class="dropdown-item position-relative drop-custom-active"
                                                data-skin="shadcn">
                                                <img src="{{ asset('admin/assets/images/themes/shadcn.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Shadcn</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="corporate">
                                                <img src="{{ asset('admin/assets/images/themes/corporate.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Corporate</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="spotify">
                                                <img src="{{ asset('admin/assets/images/themes/spotify.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Spotify</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="saas">
                                                <img src="{{ asset('admin/assets/images/themes/saas.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">SaaS</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="nature">
                                                <img src="{{ asset('admin/assets/images/themes/nature.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Nature</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="vintage">
                                                <img src="{{ asset('admin/assets/images/themes/vintage.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Vintage</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="leafline">
                                                <img src="{{ asset('admin/assets/images/themes/leafline.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Leafline</span>
                                            </button>
                                        </div>

                                        <div class="col-md-6">
                                            <button class="dropdown-item position-relative" data-skin="ghibli">
                                                <img src="{{ asset('admin/assets/images/themes/ghibli.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Ghibli</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="slack">
                                                <img src="{{ asset('admin/assets/images/themes/slack.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Slack</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="material">
                                                <img src="{{ asset('admin/assets/images/themes/material.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Material Design</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="flat">
                                                <img src="{{ asset('admin/assets/images/themes/flat.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Flat</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="pastel">
                                                <img src="{{ asset('admin/assets/images/themes/pastel.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Pastel Pop</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="caffieine">
                                                <img src="{{ asset('admin/assets/images/themes/caffieine.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Caffieine</span>
                                            </button>

                                            <button class="dropdown-item position-relative" data-skin="redshift">
                                                <img src="{{ asset('admin/assets/images/themes/redshift.svg') }}" alt=""
                                                    class="rounded me-1" height="18">
                                                <span class="align-middle">Redshift</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Notification Dropdown -->
                    {{-- <div class="topbar-item">
                        <div class="dropdown">
                            <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                data-bs-offset="0,19" type="button" data-bs-auto-close="outside"
                                aria-haspopup="false" aria-expanded="false">
                                <i data-lucide="bell" class="fs-xxl"></i>
                                <span class="badge badge-square text-bg-success topbar-badge">9</span>
                            </button>

                            <div class="p-0 dropdown-menu dropdown-menu-end dropdown-menu-lg">
                                <div class="px-3 py-2 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-md fw-semibold">Notifications</h6>
                                        </div>
                                        <div class="col text-end">
                                            <a href="#!" class="py-1 badge text-bg-light badge-label">9
                                                Alerts</a>
                                        </div>
                                    </div>
                                </div>

                                <div style="max-height: 300px;" data-simplebar>
                                    <!-- item 1 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap" id="notification-1">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0 avatar-md">
                                                <span
                                                    class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
                                                    <i data-lucide="cloud-cog" class="fs-xl fill-primary"></i>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Backup completed
                                                    successfully</span><br>
                                                <span class="fs-xs">Just now</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#notification-1">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <!-- item 2 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap" id="notification-2">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0 avatar-md">
                                                <span
                                                    class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
                                                    <i data-lucide="bug" class="fs-xl fill-primary"></i>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">New bug reported in Payment
                                                    Module</span><br>
                                                <span class="fs-xs">8 minutes ago</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#notification-2">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <!-- item 3 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap active" id="message-1">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0">
                                                <img src="{{ asset('admin/assets/images/users/user-3.jpg') }}"
                                                    class="avatar-md rounded-circle" alt="User Avatar">
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Olivia Bennett</span> shared a new
                                                report in <span class="fw-medium text-body">Weekly Planning</span><br>
                                                <span class="fs-xs">2 minutes ago</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#message-1">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <!-- item 4 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap" id="message-2">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0">
                                                <img src="{{ asset('admin/assets/images/users/user-4.jpg') }}"
                                                    class="avatar-md rounded-circle" alt="User Avatar">
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Lucas Gray</span> mentioned you in
                                                <span class="fw-medium text-body">Sprint Standup</span><br>
                                                <span class="fs-xs">14 minutes ago</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#message-2">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <!-- item 5 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap" id="message-3">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0 avatar-md">
                                                <span
                                                    class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
                                                    <i data-lucide="file-warning" class="fs-22 fill-primary"></i>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                Security policy update required for your account<br>
                                                <span class="fs-xs">22 minutes ago</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#message-3">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <!-- item 6 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap" id="notification-6">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0 avatar-md">
                                                <span
                                                    class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
                                                    <i data-lucide="mail" class="fs-xl fill-primary"></i>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">You've received a new support
                                                    ticket</span><br>
                                                <span class="fs-xs">18 minutes ago</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#notification-6">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <!-- item 7 -->
                                    <div class="py-2 dropdown-item notification-item text-wrap" id="notification-7">
                                        <span class="gap-2 d-flex">
                                            <span class="flex-shrink-0 avatar-md">
                                                <span
                                                    class="avatar-title bg-primary-subtle text-primary rounded-circle fs-22">
                                                    <i data-lucide="calendar-clock" class="fs-xl fill-primary"></i>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">System maintenance starts at 12
                                                    AM</span><br>
                                                <span class="fs-xs">1 hour ago</span>
                                            </span>
                                            <button type="button"
                                                class="flex-shrink-0 p-0 shadow-none text-muted btn btn-link"
                                                data-dismissible="#notification-7">
                                                <i data-lucide="circle-x" class="fs-xxl"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div> <!-- end dropdown -->


                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="py-2 text-center dropdown-item text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light">
                                    View All Notifications
                                </a>

                            </div>
                        </div>
                    </div> --}}

                    <!-- Button Trigger Customizer Offcanvas -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" data-bs-toggle="offcanvas"
                            data-bs-target="#theme-settings-offcanvas" type="button">
                            <i data-lucide="settings" class="fs-xxl"></i>
                        </button>
                    </div>

                    <!-- Light/Dark Mode Button -->
                    <div class="topbar-item d-sm-flex">
                        <button class="topbar-link" id="light-dark-mode" type="button">
                            <i data-lucide="moon" class="fs-xxl mode-light-moon"></i>
                            <i data-lucide="sun" class="fs-xxl mode-light-sun"></i>
                        </button>
                    </div>

                    <!-- Monochrome Mode Button -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" id="monochrome-mode" type="button">
                            <i data-lucide="palette" class="fs-xxl mode-light-moon"></i>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="px-2 topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                data-bs-offset="0,13" href="#!" aria-haspopup="false" aria-expanded="false">
                                <img src="{{ asset('admin/assets/images/users/user-2.jpg') }}" width="32"
                                    class="rounded-circle d-flex" alt="user-image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- Header -->
                                <div class="dropdown-header noti-title">
                                    <h6 class="m-0 text-overflow">Welcome back!</h6>
                                </div>

                                <!-- My Profile -->
                                <a href="#!" class="dropdown-item">
                                    <i class="align-middle ti ti-user-circle me-2 fs-17"></i>
                                    <span class="align-middle">Profile</span>
                                </a>


                                <!-- Settings -->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="align-middle ti ti-settings-2 me-2 fs-17"></i>
                                    <span class="align-middle">Account Settings</span>
                                </a>

                                <!-- Support -->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="align-middle ti ti-headset me-2 fs-17"></i>
                                    <span class="align-middle">Support Center</span>
                                </a>

                                <!-- Divider -->
                                <div class="dropdown-divider"></div>

                                <!-- Lock -->
                                <a href="auth-lock-screen.html" class="dropdown-item">
                                    <i class="align-middle ti ti-lock me-2 fs-17"></i>
                                    <span class="align-middle">Lock Screen</span>
                                </a>

                                <!-- Logout -->
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-semibold">
                                        <i class="align-middle ti ti-logout-2 me-2 fs-17"></i>
                                        <span class="align-middle">Log Out</span>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <script>
            // Skin Dropdown
            document.querySelectorAll('[data-dropdown="custom"]').forEach(dropdown => {
                const trigger = dropdown.querySelector(
                    'a[data-bs-toggle="dropdown"], button[data-bs-toggle="dropdown"]');
                const items = dropdown.querySelectorAll('button[data-skin]');

                const triggerImg = trigger.querySelector('[data-trigger-img]');
                const triggerLabel = trigger.querySelector('[data-trigger-label]');

                const config = JSON.parse(JSON.stringify(window.config));
                const currentSkin = config.skin;

                items.forEach(item => {
                    const itemSkin = item.getAttribute('data-skin');
                    const itemImg = item.querySelector('img')?.getAttribute('src');
                    const itemText = item.querySelector('span')?.textContent.trim();

                    // Set active on load
                    if (itemSkin === currentSkin) {
                        item.classList.add('drop-custom-active');
                        if (triggerImg && itemImg) triggerImg.setAttribute('src', itemImg);
                        if (triggerLabel && itemText) triggerLabel.textContent = itemText;
                    } else {
                        item.classList.remove('drop-custom-active');
                    }

                    // Click handler
                    item.addEventListener('click', function() {
                        items.forEach(i => i.classList.remove('drop-custom-active'));
                        this.classList.add('drop-custom-active');

                        const newImg = this.querySelector('img')?.getAttribute('src');
                        const newText = this.querySelector('span')?.textContent.trim();

                        if (triggerImg && newImg) triggerImg.setAttribute('src', newImg);
                        if (triggerLabel && newText) triggerLabel.textContent = newText;

                        if (typeof layoutCustomizer !== 'undefined') {
                            layoutCustomizer.changeSkin(itemSkin);
                        }
                    });
                });
            });
        </script>
