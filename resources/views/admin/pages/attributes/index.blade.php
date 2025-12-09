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
                    @include('admin.pages.attributes.parts.header')
                    @include('admin.pages.attributes.parts.filters')
                    @include('admin.pages.attributes.table')
                    @include('admin.pages.attributes.addOffCanvas')
                    @include('admin.pages.attributes.editOffCanvas')
                    @include('admin.pages.attributes.deleteModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
