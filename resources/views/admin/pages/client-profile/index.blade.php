
<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Client Profile</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.client-profile.page')
                    @include('admin.pages.client-profile.editOffCanvas')
                    @include('admin.pages.client-profile.deleteModal')
                    @include('admin.pages.client-profile.blockModal')
                    @include('admin.pages.client-profile.skinProfileModal')
                    @include('admin.pages.client-profile.beauty-info.manageConcernsModal')
                    @include('admin.pages.client-profile.addresses.addOffCanvas')
                    @include('admin.pages.client-profile.addresses.editOffCanvas')
                    @include('admin.pages.client-profile.addresses.deleteModal')
                    @include('admin.pages.client-profile.loyalty.addPointsModal')
                    @include('admin.pages.client-profile.loyalty.subtractPointsModal')
                </div>
            </div>
            @include('admin.main.footer')
        </div>
    </div>
    @include('admin.main.theme_settings')
    @include('admin.main.scripts')
    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>
</body>
</html>
