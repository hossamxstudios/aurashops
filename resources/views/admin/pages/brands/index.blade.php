<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Brands</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.brands.parts.header')
                    @include('admin.pages.brands.parts.filters')
                    @include('admin.pages.brands.table')
                    @include('admin.pages.brands.addOffCanvas')
                    @include('admin.pages.brands.editOffCanvas')
                    @include('admin.pages.brands.deleteModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
