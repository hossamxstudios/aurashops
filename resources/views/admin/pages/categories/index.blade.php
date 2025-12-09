<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Categories</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.categories.parts.header')
                    @include('admin.main.messages')
                    @include('admin.pages.categories.parts.filters')
                    @include('admin.pages.categories.table')
                    @include('admin.pages.categories.addOffCanvas')
                    @include('admin.pages.categories.editOffCanvas')
                    @include('admin.pages.categories.deleteModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
