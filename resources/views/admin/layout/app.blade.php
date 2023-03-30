<!doctype>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- style -->
    @include('admin.layout.head')
    <title>@yield('title')</title>
</head>
<body>
    @include('admin.component.nav')
    <!-- content -->
    @yield('content')
    <!-- script -->
    @include('admin.layout.script')
</body>
</html>

