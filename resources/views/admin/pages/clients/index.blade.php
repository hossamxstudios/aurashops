
<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Clients</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.clients.parts.header')
                    @include('admin.pages.clients.parts.filters')
                    @include('admin.pages.clients.table')
                    @include('admin.pages.clients.addOffCanvas')
                    @include('admin.pages.clients.editOffCanvas')
                    @include('admin.pages.clients.deleteModal')
                    @include('admin.pages.clients.blockModal')
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
