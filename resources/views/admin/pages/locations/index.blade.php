<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Locations Management</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.locations.page')
                    @include('admin.pages.locations.createModal')
                    @include('admin.pages.locations.viewModal')
                    @include('admin.pages.locations.editModal')
                    @include('admin.pages.locations.deleteModal')
                    @include('admin.pages.locations.editZoneModal')
                    @include('admin.pages.locations.deleteZoneModal')
                    @include('admin.pages.locations.editDistrictModal')
                    @include('admin.pages.locations.deleteDistrictModal')
                    @include('admin.pages.locations.addZoneModal')
                    @include('admin.pages.locations.addDistrictsModal')
                    @include('admin.pages.locations.importModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
</body>
</html>
