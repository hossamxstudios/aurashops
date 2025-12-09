<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Genders</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.genders.parts.header')
                    @include('admin.main.messages')
                    @include('admin.pages.genders.parts.filters')
                    @include('admin.pages.genders.table')
                    @include('admin.pages.genders.addOffCanvas')
                    @include('admin.pages.genders.editOffCanvas')
                    @include('admin.pages.genders.deleteModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
