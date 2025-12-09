
<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Skin Types</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.skin_types.parts.header')
                    @include('admin.pages.skin_types.parts.filters')
                    @include('admin.pages.skin_types.table')
                    @include('admin.pages.skin_types.addOffCanvas')
                    @include('admin.pages.skin_types.editOffCanvas')
                    @include('admin.pages.skin_types.deleteModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
