<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Concerns</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.concerns.parts.header')
                    @include('admin.main.messages')
                    @include('admin.pages.concerns.parts.filters')
                    @include('admin.pages.concerns.table')
                    @include('admin.pages.concerns.addOffCanvas')
                    @include('admin.pages.concerns.editOffCanvas')
                    @include('admin.pages.concerns.deleteModal')
                </div>
            </div>
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
