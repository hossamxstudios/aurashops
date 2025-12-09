
<!DOCTYPE html>
@include('admin.main.html')
<head>
    @include('admin.main.meta')
    <title>Admin - Skin Tones</title>
</head>
<body>
    <div class="wrapper">
        @include('admin.main.topbar')
        @include('admin.main.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @include('admin.pages.skin_tones.parts.header')
                    @include('admin.pages.skin_tones.parts.filters')
                    @include('admin.pages.skin_tones.table')
                    @include('admin.pages.skin_tones.addOffCanvas')
                    @include('admin.pages.skin_tones.editOffCanvas')
                    @include('admin.pages.skin_tones.deleteModal')
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
