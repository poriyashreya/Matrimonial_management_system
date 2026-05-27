<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <!-- Logo in titlebar -->
    <link rel="icon" href="{{ asset($adminFavicon ?? 'images/admin_logo.ico') }}" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Vite Assets --}}
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    @include('admin.layouts.admin_sidebar')

    <!-- MAIN -->
    <div class="flex-grow-1 ms-sidebar">

       @include('admin.layouts.admin_header')

        <!-- CONTENT -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>

        <!-- FOOTER -->
        @include('admin.layouts.admin_footer')
    </div>
</div>

@yield('scripts')
</body>
</html>
