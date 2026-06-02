<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>

    <!-- Logo in titlebar -->
    <link rel="icon" href="{{ asset('images/logo3.ico') }}" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        window.routes = {
            rate: "{{ route('rating.store') }}",
            skip: "{{ route('rating.skip') }}"
        };

        window.ratingData = {
            status: @json($rating_status ?? "new")
        };

        console.log(window.routes);
    </script>

    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <!-- Header -->
    @include('layouts.header')

    <!-- Main Content -->
    <main style="padding-top: 40px; padding-bottom: 0%;">
        <!-- Featured Profiles -->
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>