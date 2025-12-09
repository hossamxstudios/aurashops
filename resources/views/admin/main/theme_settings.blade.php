
    <!-- Theme Settings -->
    <div class="overflow-hidden offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
        <div class="gap-2 p-3 d-flex justify-content-between text-bg-primary"
            style="background-image: url({{ asset('admin/assets/images/user-bg-pattern.png') }})">
            <div>
                <h5 class="mb-1 text-white fw-bold text-uppercase">Admin Customizer</h5>
                <p class="mb-0 text-white text-opacity-75 fst-italic fw-medium">Easily configure layout, styles, and
                    preferences for your admin interface.</p>
            </div>

            <div class="flex-grow-0">
                <button type="button"
                    class="text-white bg-white bg-opacity-25 d-block btn btn-sm rounded-circle btn-icon"
                    data-bs-dismiss="offcanvas"><i class="ti ti-x fs-lg"></i></button>
            </div>
        </div>

        <div class="p-0 offcanvas-body h-100" data-simplebar>

            <div class="p-3 border-dashed border-bottom">
                <h5 class="mb-3 fw-bold">Color Scheme</h5>
                <div class="row">
                    <div class="col-4">
                        <div class="form-check card-radio">
                            <input class="form-check-input" type="radio" name="data-bs-theme"
                                id="layout-color-light" value="light">
                            <label class="p-0 form-check-label w-100" for="layout-color-light">
                                <img src="{{ asset('admin/assets/images/layouts/light.svg') }}" alt="layout-img" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center text-muted">Light</h5>
                    </div>

                    <div class="col-4">
                        <div class="form-check card-radio">
                            <input class="form-check-input" type="radio" name="data-bs-theme"
                                id="layout-color-dark" value="dark">
                            <label class="overflow-hidden p-0 form-check-label w-100" for="layout-color-dark">
                                <img src="{{ asset('admin/assets/images/layouts/dark.svg') }}" alt="layout-img"
                                    class="overflow-hidden img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center text-muted">Dark</h5>
                    </div>
                </div>
            </div>

            <div class="p-3 border-dashed border-bottom">
                <h5 class="mb-3 fw-bold">Topbar Color</h5>

                <div class="row g-3">
                    <div class="col-4">
                        <div class="form-check card-radio">
                            <input class="form-check-input" type="radio" name="data-topbar-color"
                                id="topbar-color-light" value="light">
                            <label class="p-0 form-check-label w-100" for="topbar-color-light">
                                <img src="{{ asset('admin/assets/images/layouts/topbar-light.svg') }}" alt="layout-img" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center text-muted">Light</h5>
                    </div>

                    <div class="col-4">
                        <div class="form-check card-radio">
                            <input class="form-check-input" type="radio" name="data-topbar-color"
                                id="topbar-color-dark" value="dark">
                            <label class="p-0 form-check-label w-100" for="topbar-color-dark">
                                <img src="{{ asset('admin/assets/images/layouts/topbar-dark.svg') }}" alt="layout-img" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center fs-sm text-muted">Dark</h5>
                    </div>
                </div>
            </div>

            <div class="p-3 border-dashed border-bottom">
                <h5 class="mb-3 fw-bold">Sidenav Color</h5>

                <div class="row g-3">
                    <div class="col-4">
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidenav-color"
                                id="sidenav-color-light" value="light">
                            <label class="p-0 form-check-label w-100" for="sidenav-color-light">
                                <img src="{{ asset('admin/assets/images/layouts/light.svg') }}" alt="layout-img" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center fs-sm text-muted">Light</h5>
                    </div>

                    <div class="col-4">
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidenav-color"
                                id="sidenav-color-dark" value="dark">
                            <label class="p-0 form-check-label w-100" for="sidenav-color-dark">
                                <img src="{{ asset('admin/assets/images/layouts/sidenav-dark.svg') }}" alt="layout-img" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center fs-sm text-muted">Dark</h5>
                    </div>
                </div>
            </div>

            <div class="p-3 border-dashed border-bottom">
                <h5 class="mb-3 fw-bold">Sidebar Size</h5>

                <div class="row g-3">
                    <div class="col-4">
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidenav-size"
                                id="sidenav-size-small-hover-active" value="default">
                            <label class="p-0 form-check-label w-100" for="sidenav-size-small-hover-active">
                                <img src="{{ asset('admin/assets/images/layouts/light.svg') }}" alt="layout-img" class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center fs-base text-muted">Default</h5>
                    </div>

                    <div class="col-4">
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-sidenav-size"
                                id="sidenav-size-small-hover" value="collapse">
                            <label class="p-0 form-check-label w-100" for="sidenav-size-small-hover">
                                <img src="{{ asset('admin/assets/images/layouts/sidebar-condensed.svg') }}" alt="layout-img"
                                    class="img-fluid">
                            </label>
                        </div>
                        <h5 class="mt-2 mb-0 text-center text-muted">Collapse</h5>
                    </div>
                </div>
            </div>

            <div class="p-3 border-dashed border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Layout Position</h5>
                    <div class="btn-group radio" role="group">
                        <input type="radio" class="btn-check" name="data-layout-position"  id="layout-position-fixed" value="fixed">
                        <label class="btn btn-sm btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>
                        <input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
                        <label class="btn btn-sm btn-soft-primary w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                    </div>
                </div>
            </div>
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><label class="m-0 fw-bold" for="sidebaruser-check">Sidebar User Info</label>
                    </h5>
                    <div class="form-check form-switch fs-lg">
                        <input type="checkbox" class="form-check-input" name="sidebar-user" id="sidebaruser-check">
                    </div>
                </div>
            </div>
        </div>
    </div>
